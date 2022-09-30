<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\ToyController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\BathController;
use App\Http\Controllers\ProductController;
use App\Services\GeneralService;

class AdminProductService
{
    protected $generalService;
    protected $detailsClassObj;
    protected $test;
    
    public function __construct(Request $request)
    {
        $this->generalService = new GeneralService();

        if (! empty($request->product_type)) {
            $detailControllerClassName = 'App\Http\Controllers\\' . $this->defineDetailTableName(Str::lower($request->product_type));
            
            $this->test = $detailControllerClassName;
            $this->detailsClassObj = new $detailControllerClassName(); 
        }
    }

    //Define name of detail's table name
    private function defineDetailTableName($tableName)
    {
        $requestTableName = strtolower($tableName);

        if ($requestTableName == 'feed') {           
            $detailControllerClassName = 'FeedController';     
        }
        if ($requestTableName == 'bath') {
            $detailControllerClassName = 'BathController';
        }
        if ($requestTableName == 'toies') {
            $detailControllerClassName = 'ToyController';
        }
        if ($requestTableName == 'products') {
            $detailControllerClassName = 'ProductController';
        }
        
        return $detailControllerClassName;
    }
    //Get data 
    public function getDataByIdForSelect($id, Request $request)
    {
        //
        if ($request->table_name == 'animals_product_types') {

            $product_types = DB::table('animals_product_types')           
                            ->select('animals_product_types.product_type_id AS id', 'product_types.name')
                            ->leftJoin('product_types', 'animals_product_types.product_type_id', '=', 'product_types.id')
                            ->where('animals_product_types.animal_id', $id)
                            ->get();

             $brands = DB::table('animals_brands')
                            ->select('animals_brands.brand_id AS id', 'brands.name')
                            ->leftJoin('brands', 'animals_brands.brand_id', '=' ,'brands.id')
                            ->where('animals_brands.animal_id', $id)
                            ->get();
        }

        return [$product_types, $brands];
    }
    //Prepare product's array
    private function productRequestAsArray($request, $image_path)
    {
        $array = [];

        $array = [
            'name' => $request->name,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'image_path' => $image_path,
            'brand_id' => intval($request->brand_id),
            'product_type_id' => intval($request->product_type_id),
            'animal_id' =>intval($request->animal_id),
            'price' => floatval($request->price),
            'articul' => $request->articul, 
            'is_new' => boolval($request->is_new),       
        ];

        return $array;
    }
    //Prepare details' array
    private function prepareProductsData($request, $image_path)
    {
        $arrToProdUpdate = [];
        $productObj = new ProductController();
        
        //Get product's information   
        $product = $productObj->get($request->id)->toArray();

        //Loop all product's info
        foreach ($product as $key => $value) {
            if (
                $key == 'created_at' || $key == 'updated_at' || 
                $key == 'brand_id' || $key == 'product_type_id'|| 
                $key == 'animal_id'
            ) {
                continue;
            }
            //Check if image was changed
            if ($key == 'image_path') {
                //if image was not added
                if (empty($image_path) === true) {
                    continue;   
                }
                //if images are equal
                if (strcmp($key, $request->$key) != 0) {
                    $arrToProdUpdate[$key] = $image_path;
                    continue;
                }
            }
            //Check status is_new
            if ($key == 'is_new') {
                $request->$key == $value?:  $arrToProdUpdate[$key] = boolval($request->$key);
                continue;
            }
            //Add to array if values are distinct
            if ($value != $request->$key && isset($request->$key)) {
                $arrToProdUpdate[$key] = $request->$key;
            }
        }
    
        return $arrToProdUpdate;
    }
    //
    private function requestValidate($request)
    {
       //Preapare params
       $key_request = '';
       $rules = [];
       $messages = [];
       //Set all values what have to be validate
       $rules_template = [
            'name' => 'required',
            'table_name' => 'alpha',
            'short_description' => 'required|max:15|min:10',
            'long_description' => 'required|min:20',
            'brand_id' => 'required',
            'product_type_id' => 'required',
            'animal_id' => 'required',
            'price' => 'required|numeric',
            'articul' => 'required',
        ];
        //Set custom messages
        $messages_template = [
            'name.required' => 'The name is required.',
            'short_description.required' => 'The description is required.',
            'long_description.required' => 'The description is required.',
            'brand_id.required' => 'The brand is required.',
            'product_type_id.required' => 'The category is required.',
            'animal_id.required' => 'The animal is required.',
            'price.required' => 'The price is required.',
            'articul.required' => 'The articul is required.',
        ];
        //Make array of rules for current request
        foreach ($request->all() as $key => $notUSed) {
           //if key exists in rules_template then add it to the rules
           if (array_key_exists($key, $rules_template)) $rules[$key] = $rules_template[$key]; 
           //if key exists in messages_template then add to it the  messages
           $key_request = $key . '.required';
           if (array_key_exists($key_request, $messages_template)) $messages[$key_request] = $messages_template[$key_request]; 
        }
        //Validate request
        if (count($messages) > 0) {
           $validator = Validator::make($request->all(), $rules, $messages);
        } else {
           $validator = Validator::make($request->all(), $rules);
        }    
        //Return errors 
        if ($validator->fails()) {
            return $validator->errors() ;
        }
        //Return 'false' if there are no arrors
        return 'false';  
    }  
    //Store new product
    public function store(Request $request)
    {
        $subFolder = 'products';
        $insert_details = [];

        //Validation
        $validated = $this->requestValidate($request);
        
        if ($validated != 'false') {
            return $validated;
        }

        //Check/store image
        $image_path = $this->generalService->storeImage($request, $subFolder);  
        
        //Prepare array
        $arrToStore = $this->productRequestAsArray($request, $image_path);
        
        //Store product data
        $productObj = new ProductController();
        $product_id = $productObj->store($arrToStore)->id;

        //Store details in DB
        $tableColNames = $this->generalService->getColNamesFromSchema($request->product_type);
        
        $colToSelect = $this->generalService->excludeFilterColNames($tableColNames);
        
        
        foreach ($colToSelect as $key => $val) {
            $insert_details[$val] = $request->$val;
        }
        
        //Add product id
        $insert_details['product_id'] = $product_id;
        // return [$insert_details, $this->test, $product_id];
        $this->detailsClassObj->store($insert_details); 
    }
    //
    public function update(Request $request)
    {      
        $subFolder = 'products';
        $arrToUpdateDet = [];
        $productObj = new ProductController();
       
        //Validate from
        $validated = $this->requestValidate($request);

        if ($validated != 'false') {
            return $validated;
        }

        //Check/store image
        $image_path = $this->generalService->storeImage($request, $subFolder);  

        //Prepare data for updating
        $arrToProdUpdate = $this->prepareProductsData($request, $image_path);

        //Update product data 
        if (count($arrToProdUpdate) > 0) {          
            $productObj->update($request->id, $arrToProdUpdate);
        }
    
        //Get product details       
        $productDetailsArray = $this->detailsClassObj->getByProductId($request->id)->toArray();

        //Loop all product's details 
        if (! $productDetailsArray) {
            return;
        }
        foreach ($productDetailsArray[0] as $key => $value) {
            if (
                $key == 'created_at' || $key == 'updated_at' || 
                $key == 'id' || $key == 'product_id' || $key == 'product_type_id' ||  $key == 'brand_id'
            ) {
                 continue;
            }
            //Add to array if values are distinct
            if ($value != $request->$key && isset($request->$key)) {
                $arrToUpdateDet[$key] = $request->$key;
            }
        }

        //Update product's details  
        if (count($arrToUpdateDet) > 0) {
            $this->detailsClassObj->updateByProductId($request->id, $arrToUpdateDet); 
        }
        
    }
}
