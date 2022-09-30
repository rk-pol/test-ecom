<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductService
{
    //Get data 
    public function getDataByIdForSelect($id, Request $request)
    {
        //
        if ($request->table_name == 'providers_brands') {
            $data = DB::table('providers_brands')
                            ->select('providers_brands.brand_id AS id', 'brands.name')
                            ->leftJoin('brands', 'providers_brands.brand_id', '=' ,'brands.id')
                            ->where('providers_brands.provider_id', $id)
                            ->get();
        }
        if ($request->table_name == 'animals_categories') {
            $data = DB::table('animals_categories')           
                            ->select('animals_categories.product_type_id AS id', 'product_types.name')
                            ->leftJoin('product_types', 'animals_categories.product_type_id', '=', 'product_types.id')
                            ->where('animals_categories.animal_id', $id)
                            ->get();
        }
        
        return $data;
    }
}
