<?php

namespace App\Http\Controllers;

use App\Services\AnimalService;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProviderController;

class AdminUserController extends Controller
{
    protected $animalService;
    protected $brands;
    protected $animals;
    protected $providers;

    public function __construct()
    {
        $this->animalService = new AnimalService();
        $this->brands = new BrandController();
        $this->animals = new AnimalController();
        $this->providers = new ProviderController();
    }
    //
    public function index()
    {
        $animals_arr = $this->animalService->dataForMainNavPanel();
        $brands = $this->brands->all();
        $animals = $this->animals->all();
        $providers = $this->providers->all();

        return view('admin.users', [    
                                    'animals_arr' => $animals_arr,
                                    'providers' => $providers,
                                    'animals' => $animals,
                                    'brands' => $brands
        ]);
    }
}
