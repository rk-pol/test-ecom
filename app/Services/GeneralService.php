<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class GeneralService
{
    public function makeOrderConditionByOptions($request)
    {
        $orderByArr = [];
         //Set limit of query's execute
        if (empty($request->limitLines)) {
            $orderByArr['limit'] = 15;
        } else {
            $orderByArr['limit']  = $request->limitLines;
        }
        //Set default sort order if it was not received
        if (empty($request->sortBy)) {
            $orderByArr['colName']  = 'id';
            $orderByArr['sortBy']  = 'ASC';
        } else {
            $sort_arr = explode('_', $request->sortBy);
            $orderByArr['colName'] = $sort_arr[0];
            $orderByArr['sortBy']  = $sort_arr[1];
        }
        
        return $orderByArr;
    }
    //
    public function storeImage($request, $subFolder)
    {
        if (empty($request->file('image_file')) === false) {
            $file = $request->file('image_file');
            $upload_folder = 'assets/img/' . $subFolder;
            $filename = $file->getClientOriginalName(); // image.jpg
            $image_path = $upload_folder . '/' . $filename;      
            // Safe img in assets/img
            Storage::putFileAs($upload_folder, $file, $filename);

            return $image_path;
        } else {
            return null;
        }
    }

    //Get all columns from table with details 
    public function getColNamesFromSchema($table_name)
    {
        //Get all columns from table with details 
        $tableColNames = Schema::getColumnListing($table_name);

        return $tableColNames;
    }

    //Make an array from object
    public function fromObjToArray($DBobject)
    {
        $array = json_decode(json_encode($DBobject), true);

        return $array;
    }

    //
    public function arrayImplode($separator, $arr)
    {
        $arrStr = implode($separator, $arr);
        
        return $arrStr;  
    }
    //Return array in string by separator
    public function SrtInArrBySeparator($str, $separator = '_')
    {   
        $arr = explode($separator, $str);

        return $arr;
    }
    //Return array without received fields
    public function excludeFilterColNames($array)
    {
        $filtered_array = array_filter($array, function($value){
                            if (
                                $value == 'created_at' || $value == 'updated_at' || 
                                $value == 'id' || $value == 'product_id'
                            ) {
                                return false;
                            } else {
                                return true;
                            }
        });

        return $filtered_array;
    }

    
}
