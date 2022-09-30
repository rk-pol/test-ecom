<?php

namespace App\Http\Controllers;

use App\Models\AnimalBrand;

class AnimalBrandController extends Controller
{   
    //Store
    public function store(Array $array)
    {
        AnimalBrand::create($array);
    }
}
