<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Services\AnimalService;
use App\Services\GeneralService;
use App\Services\AnimalProductTypeService;
use App\Models\Product;

class HomeController extends Controller
{  
    //Get page
    public function index() 
    {
        $animals_arr = AnimalService::dataForMainNavPanel(); 

        //Get all products where params 'is_new' = true
        $new_products = Product::select('products.*', 'product_types.name AS product_type', 'animals.name AS animal')->where('is_new', true)
                                            ->leftjoin('product_types', 'products.product_type_id', '=', 'product_types.id')
                                            ->leftjoin('animals', 'products.animal_id', '=', 'animals.id')
                                            ->where('is_new', true)
                                            ->limit(5)
                                            ->get();   

        //Get all products where solds were max                        
        $hit_products = DB::table(DB::raw('(SELECT product_id AS id, SUM(value) AS sold FROM products_solds GROUP BY product_id) solds'))
                            ->leftjoin(
                                DB::raw("(SELECT product_id AS id, SUM(value) AS received FROM products_receiveds GROUP BY product_id) received"),
                                function($join)
                                {
                                    $join->on('received.id', '=', 'solds.id');
                                })
                            ->leftjoin('products', 'products.id', '=', 'solds.id')
                            ->leftjoin(
                                DB::raw("(SELECT name AS animal, id FROM animals) animals"),
                                function($join)
                                {
                                    $join->on('products.animal_id', '=', 'animals.id');
                                })
                            ->leftjoin(
                                DB::raw("(SELECT name AS product_type, id FROM product_types) prod_types"),
                                function($join)
                                {
                                    $join->on('products.product_type_id', '=', 'prod_types.id');
                                })
                            // ->select('*')    
                            ->limit(7)
                            ->get();

        return view('index', [
                                    'animals_arr' => $animals_arr,
                                    'new_products' => $new_products,
                                    'hit_products' => $hit_products
        ]);    
    }     
    //Get page by selected single animal with data from DB
    public function showAnimalPage(
                                    $name, 
                                    Request $request, 
                                    AnimalController $animals, 
                                    AnimalProductTypeService $animal_product_type_service,
                                    ProductController $products
    ) {
        //Get all animals for main nav panel                            
        $animals_arr = AnimalService::dataForMainNavPanel(); 
        //Get animal's id by received name
        $animal_id = $animals->getByName($name)->id;
        //
        $request->merge(['id' => $animal_id]);
        //Get all categories by animal id
        $animal_product_types = $animal_product_type_service->getProductTypesByAnimalId($animal_id);
        //Get all products by animal id                                                  
        $animal_products =  $products->allByAnimalId($request);

        return view("animals.animal_page", [
                                            'animal_product_types' => $animal_product_types,
                                            'animals_arr' => $animals_arr,
                                            'animal_products' => $animal_products,
                                            'animal' => $name
        ]);
    }   
    //
    public function showAnimalCategoryPage(
                                            $animal, 
                                            $product_type, 
                                            Request $request, 
                                            ProductTypeController $product_types, 
                                            AnimalController $animals,
                                            AnimalProductTypeService $animal_product_type_service,
                                            ProductController $products
    ) {
        //Get all animals for main nav panel
        $animals_arr = AnimalService::dataForMainNavPanel(); 

        $product_type_id = $product_types->getByName($product_type)->id;

        $animal_id = $animals->getByName($animal)->id;

        $animal_product_types = $animal_product_type_service->getProductTypesByAnimalId($animal_id);

        $animal_products = $products->allByAnimalIdProductTypeId($animal_id, $product_type_id, $request);
        
        return view('animals.animal_category_page', [
                                                    'animals_arr' => $animals_arr, 
                                                    'animal_products' => $animal_products,
                                                    'currCategory' => Str::ucfirst($product_type),
                                                    'animal_categories' => $animal_product_types,
                                                    'animal' => $animal
        ]);
    }
    //
    public function showProductPage($animalNameNoUsed, $animalCategory, $product_id)
    {           
        $animals_arr = AnimalService::dataForMainNavPanel(); 

        $product = DB::table(DB::raw("(SELECT * FROM products WHERE id=$product_id) products"))
                        ->leftjoin(
                            DB::raw("(SELECT name AS brand, id as brand_id FROM brands) brands"),
                            function($join)
                            {
                                $join->on('products.brand_id', '=', 'brands.brand_id');
                            }) 
                        ->first();
        // dd($product);
        //Get all columns from table with details   
        $generalService = new GeneralService(); 
        $tableColNames = $generalService->getColNamesFromSchema($animalCategory);

        //Return array without several values
        $filtered_array = $generalService->excludeFilterCOlNames($tableColNames);  

        //Array into string                
        $arrStr = $generalService->arrayImplode(', ', $filtered_array);  

        //Get details                                                 
        $details = DB::table(DB::raw("(SELECT $arrStr FROM $animalCategory WHERE product_id=$product_id) details"))
                            ->first();
        
        return view('products.product_page', [
                                            'animals_arr' => $animals_arr,
                                            'product' => $product,
                                            'details' => $details
        ]);
    }
   //Cart
   public function getAllProducts(Request $request)
   {
        $arrId = [];
        $arrProducts = json_decode(json_encode($request->productsId), true, 3);

        foreach ($arrProducts as $noUsed => $value) {
            $arrId[] = $value['id'];
        }

        $productData = Product::select('id', 'name', 'image_path', 'price')
                                                                ->whereIn('id', $arrId)
                                                                ->get();
        return $productData;
   }
   //Get product's price by id
   public function getProdPrice($id) 
   {
        $arrParams = [
                'table_name' => 'products',
                'condName' => 'id',
                'condVal' => $id,
                'valField' => 'price'
        ];

        $prodPrice = $this->getSingleDataByField($arrParams);

        return $prodPrice;
   } 
    //

}

