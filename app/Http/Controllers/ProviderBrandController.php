<?php

namespace App\Http\Controllers;

use App\Models\ProviderBrand;


class ProviderBrandController extends Controller
{
    //Store data
    public function store(Array $array)
    {
       ProviderBrand::create($array);
    }
}
