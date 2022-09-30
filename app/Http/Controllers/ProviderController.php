<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Services\AnimalService;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    //Get page
    public function index(
                            AnimalService $AnimalService, 
                            BrandController $brands,  
                            AnimalController $animals, 
                            ProviderController $providers
    ) {

        $animals_arr = $AnimalService->dataForMainNavPanel();
        $brands = $brands->all();
        $animals = $animals->all();
        $providers = $providers->all();

        return view('admin.create.provider', [    
                                            'animals_arr' => $animals_arr,
                                            'providers' => $providers,
                                            'animals' => $animals,
                                            'brands' => $brands
        ]);
    }
    //Get all providers
    public function all()
    {
        return Provider::all();
    }
    //Store new provider
    public function store(Request $reuqest)
    {
        Provider::create(['name' => $reuqest->name]);    
    }
    //Edit provider
    public function edit(Request $request)
    {
        Provider::find($request->id)->update(['name' => $request->name]);
    }
    //Delete provider
    public function delete(Request $request)
    {
        Provider::find($request->id)->delete();
    }
    //Return provider 
    public function show($id)
    {
        return Provider::find($id)->get();
    }
    
}
