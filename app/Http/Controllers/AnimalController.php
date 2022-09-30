<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Services\AnimalService;
use App\Http\Controllers\ProductTypeController;

class AnimalController extends Controller
{
    protected $animalService;
    protected $productTypes;

    public function __construct()
    {
        $this->animalService = new AnimalService();
        $this->productTypes = new ProductTypeController();

    }
    //Get page
    public function index()
    {
        
        $animals_arr = $this->animalService->dataForMainNavPanel();
        $animals = $this->all();
        $product_types = $this->productTypes->all();

        return view('admin.create.animal', [    
                                            'animals_arr' => $animals_arr,
                                            'animals' => $animals,
                                            'product_types' =>$product_types
        ]);
    }
    //Get all animals
    public function all()
    {
        return Animal::all();
    }
    //Store new animal
    public function store(Request $reuqest)
    {
        Animal::create(['name' => $reuqest->name]); 
    }
    //Edit animal
    public function edit(Request $request)
    {
        Animal::find($request->id)->update(['name' => $request->name]);
    }
    //Delete animal
    public function delete(Request $request)
    {
        Animal::find($request->id)->delete();
    }
    //Return animal by id
    public function show($id)
    {
        return Animal::find($id)->get();
    }
    //
    public function getByName($name)
    {
        return Animal::select('*')->where('name', $name)->first();
    }
}
