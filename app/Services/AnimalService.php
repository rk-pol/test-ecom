<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Animal;

class AnimalService
{
    
    //Get data for main navigation panel
    public static function dataForMainNavPanel()
    {
        $animals_arr = [];
        $animals = Animal::select('animals.name AS animal_name' , 'product_types.name', 'animals_product_types.image_path')
                            ->leftjoin('animals_product_types', 'animals.id' , '=', 'animals_product_types.animal_id')
                            ->leftjoin('product_types', 'animals_product_types.product_type_id' , '=', 'product_types.id')
                            ->get()->toArray();
                                                                            
        foreach ($animals as $animal) {
            $name = $animal['animal_name'];
            if (!array_key_exists($name, $animals_arr)) {
                $animals_arr[$name] = [$animal['name'] => $animal['image_path']];
            } else {
                $animals_arr[$name][$animal['name']] = $animal['image_path'];            
            }
        }

        return $animals_arr;
    }
    //Get all data by table name
    public function show(Request $request)
    {
        $data = DB::table($request->table_name)->select('id', 'name')->get();
        
        return $data;
    }

}
