<?php

namespace App\Services;

class AdminService
{
    
    //
    public function makeQueryCondition($request)
    {
        $queryCondition = 'WHERE ';
        //Make condition for selected options
        if ($request->animal !== 'null') {
            $queryCondition .= 'animal_id = ' . $request->animal;
        }
        if ($request->brand !== 'null') {
            if(strlen($queryCondition) > 6) {
                $queryCondition .= ' AND ';
            }
            $queryCondition .= 'brand_id = ' . $request->brand;
        }
        if ($request->category !== 'null') {
            if (strlen($queryCondition) > 6) {
                $queryCondition .= ' AND ';
            }
            $queryCondition .= 'product_type_id = ' . $request->category;
        }
        //If conditions were not sent
        if (strcmp($queryCondition, 'WHERE ') == 0) {
            $queryCondition = '';
        }

        return $queryCondition;
    }
    //Prepare result
    public function prepareResult($result)
    {
        $arrResult = [];
        $count = 0;
        //Looping result for making an arr
        foreach ($result as $obj) {
            $animal = $obj->animal;
            $type = $obj->type;
            if (array_key_exists($animal, $arrResult) === false) {
                $arrResult[$animal] = [];
            } 
            if (array_key_exists($type, $arrResult[$animal]) === false ) {
                $count = 0;
                $arrResult[$animal][$type] = [];
            }  

            $arrResult[$animal][$type][] = [];
            
            foreach ($obj as $key => $val) {
                if ($key == 'type') {
                    continue;
                }
                $arrResult[$animal][$type][$count][$key] = $val;
            }
            $count += 1;
        }  
       
        return  $arrResult;
    }
    //
    public function getBrandsProvidersByAnimalId(
                                $id, 
                                AnimalBrandService $brands,
                                AnimalProductTypeService $product_types
    ) {
        
        $brands = $brands->getBrandsByAnimalId($id);

        $product_types = $product_types->getProductTypesByAnimalId($id);

        return [$brands, $product_types];
    }

}
