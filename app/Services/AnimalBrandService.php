<?php

namespace App\Services;

use App\Http\Controllers\AnimalBrandController;
use App\Models\AnimalBrand;
use Illuminate\Http\Request;


class AnimalBrandService
{
   //Make dependecies 
   public function makeDependecy(Request $request, AnimalBrandController $animal_brands)
   {    
      $arrToInsert = [      
                        $request->first_name => $request->first_id,
                        $request->second_name  => $request->second_id,
                        'animal_brand' => $request->first_id . '_' . $request->second_id
      ];  
      
      $result = $animal_brands->store($arrToInsert);

      return $result;
   }
   //
   public function getBrandsByAnimalId($id)
   {
      $result = AnimalBrand::select('animals_brands.brand_id AS id', 'brands.name AS value')
                              ->where('animals_brands.animal_id', $id)
                              ->leftjoin('brands', 'animals_brands.brand_id', '=', 'brands.id')
                              ->get();

      return $result;
   }

}
