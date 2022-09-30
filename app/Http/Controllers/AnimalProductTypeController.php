<?php

namespace App\Http\Controllers;

use App\Models\AnimalProductType;

class AnimalProductTypeController extends Controller
{
    //
    //Store data
    public function store(Array $array)
    {
        AnimalProductType::create($array);
    }
}
