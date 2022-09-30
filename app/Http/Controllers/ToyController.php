<?php

namespace App\Http\Controllers;

use App\Models\Toy;

class ToyController extends Controller
{
    //
    public function store($array)
    {
        Toy::create($array);   
    }
    //
    public function update($id, $array)
    {
        Toy::find($id)->update($array);
    }
    //
    public function get($id)
    {
        return Toy::find($id);
    }
    //
    public function getByProductId($id)
    {
        return Toy::where('product_id', $id)->get();
    }
    //
    public function updateByProductId($id, $array)
    {
        Toy::where('product_id', $id)->update($array);
    }

}
