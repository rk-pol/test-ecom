<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\AnimalService;
use App\Services\GeneralService;
use App\Models\Product;

class ProductController extends Controller
{
    
    //
    public function index(
                            AnimalService $AnimalService,
                            BrandController $brands,
                            AnimalController $animals,
                            ProviderController $providers
    ) {
        $animals_arr = $AnimalService->dataForMainNavPanel();
        $brands = $brands->all();
        $animals = $animals->all();
        $providers = $providers->all();

        return view('admin.create.product', [    
                                                'animals_arr' => $animals_arr,
                                                'providers' => $providers,
                                                'animals' => $animals,
                                                'brands' => $brands
        ]);
    }
    //Get all products by animal id
    public function allByAnimalId(Request $request)
    {
        $generalService = new GeneralService();

        $orderByArr = $generalService->makeOrderConditionByOptions($request);

        $result = Product::select('products.*', 'product_types.name AS product_type')
                                    ->where('animal_id', $request->id)
                                    ->leftjoin('product_types', 'products.product_type_id', '=', 'product_types.id')
                                    ->limit($orderByArr['limit'])
                                    ->orderBy($orderByArr['colName'], $orderByArr['sortBy'])
                                    ->paginate(8); 
        
        return $result;
    }
    //
    public function allByAnimalIdProductTypeId($animal_id, $product_type_id, Request $request)
    {
        $generalService = new GeneralService();

        $orderByArr = $generalService->makeOrderConditionByOptions($request);
        
        $result = Product::select('*')->where('animal_id', $animal_id)
                                        ->where('product_type_id', $product_type_id)
                                        ->orderBy($orderByArr['colName'], $orderByArr['sortBy'])
                                        ->paginate(8);
                                        
        return $result;
    }
    //
    public function store($array)
    {
        return Product::create($array);
    }
    //
    public function get($id)
    {   
       return Product::find($id);
    }
    //
    public function delete(Request $request)
    {
        Product::find($request->id)->delete();
    }
    //
    public function update($id, $array)
    {
        Product::find($id)->update($array);
    }
    //
    public function showEdit(
                        $id, 
                        AnimalService $AnimalService, 
                        AnimalController $animals, 
                        BrandController $brands,
                        ProductTypeController $product_types,
                        GeneralService $generalService
    ) {

        $animals_arr = $AnimalService->dataForMainNavPanel();
        //Get all animals
        $animals = $animals->all();
        //Get all brands
        $brands = $brands->all();
        //Get all product types
        $all_product_types = $product_types->all();
        //Get all information by product id 
        $product = Product::find($id);
        //Get category's name
        $product_type = $product_types->get($product->product_type_id)->name;
        //Get all columns from table with details 
        $tableColNames = $generalService->getColNamesFromSchema($product_type);
        //Return array without several values
        $filtered_array = $generalService->excludeFilterColNames($tableColNames);    
        //Array into string                
        $arrStr = implode(', ', $filtered_array);     
        //                                               
        $details = DB::table(DB::raw("(SELECT $arrStr FROM $product_type WHERE product_id=$product->id) details"))->first();   
        //      
        return view('main.edit_product_page', [
                                            'animals' => $animals,
                                            'categories' => $all_product_types,
                                            'brands' => $brands,
                                            'animals_arr' => $animals_arr,
                                            'product' => $product,
                                            'details' => $details
        ]); 
    }
}
