<?php

namespace App\Services;

use App\Http\Controllers\ProviderBrandController;
use Illuminate\Http\Request;

class ProviderBrandService
{
   //Make dependecies
   public function makeDependecy(Request $request, ProviderBrandController $provider_brand)
   {
      
        $arrToInsert = [      
                            $request->first_name => $request->first_id,
                            $request->second_name  => $request->second_id,
                            'provider_brand' => $request->first_id . '_' . $request->second_id
         ];  

        $result = $provider_brand->store($arrToInsert);

        return $result;
   }
   
}
