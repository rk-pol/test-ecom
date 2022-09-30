<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
     //Get all brands
     public function all()
     {
         return Brand::all();
     }
     //Store new brand
     public function store(Request $reuqest)
     {
        Brand::create(['name' => $reuqest->name]);
     }
     //Edit brand
     public function edit(Request $request)
     {
        Brand::find($request->id)->update(['name' => $request->name]);
     }
     //Delete brand
     public function delete(Request $request)
     {
        Brand::find($request->id)->delete();
     }
     //Return brand 
     public function show($id)
     {
         return Brand::find($id)->get();
     }
}
