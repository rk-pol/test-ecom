<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    //Get all 
    public function all()
    {
        return ProductType::all();
    }

    //Edit 
    public function edit(Request $request)
    {
        ProductType::find($request->id)->update(['name' => $request->name]);
    }
    //Delete 
    public function delete(Request $request)
    {
        ProductType::find($request->id)->delete();
    }
    //Return animal 
    public function get($id)
    {
        return ProductType::find($id)->first();
    }
    //Store new
    public function store(Request $reuqest)
    {
        ProductType::create(['name' => $reuqest->name]);    
    }
    //Get by animal id
    public function getByName($name)
    {
        return ProductType::select('*')->where('name', $name)->first();
    }

}
