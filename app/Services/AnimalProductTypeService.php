<?php

namespace App\Services;

use App\Http\Controllers\AnimalProductTypeController;
use App\Models\AnimalProductType;
use Illuminate\Http\Request;


class AnimalProductTypeService
{
   //Make dependecies 
   public function makeDependecy(
                           Request $request, 
                           AnimalProductTypeController $animal_product_types, 
                           GeneralService $generalService
   ) {    
      $subFolder = 'main/sub_menu';

      $arrToInsert = [      
                        $request->first_name => $request->first_id,
                        $request->second_name  => $request->second_id,
                        'animal_product_type' => $request->first_id . '_' . $request->second_id
      ];  

      $image_path = $generalService->storeImage($request, $subFolder);
      
      $arrToInsert['image_path'] = $image_path;
 
      $result = $animal_product_types->store($arrToInsert);

      return $result;
   }
   //
   public function getProductTypesByAnimalId($id)
   {
      $result = AnimalProductType::select('animals_product_types.*', 'product_types.name AS name')
                                    ->where('animal_id', $id)
                                    ->leftjoin('product_types', 'animals_product_types.product_type_id', '=', 'product_types.id')
                                    ->get(); 
    
     return $result;
   }
}
