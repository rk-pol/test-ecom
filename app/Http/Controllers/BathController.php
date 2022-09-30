<?php

namespace App\Http\Controllers;

use App\Models\Bath;

class BathController extends Controller
{
    //
    public function store($array)
    {
      Bath::create($array);
    }
    //
    public function update($id, $array)
    {
        Bath::find($id)->update($array);
    }
    //
    public function edit($id)
    {
        return Bath::find($id);
    }
    //
    public function getByProductId($id)
    {
        return Bath::where('id_products', $id)->get();
    }
    //
    public function updateByProductId($id, $array)
    {
        Bath::where('id_products', $id)->update($array);
    }
}
