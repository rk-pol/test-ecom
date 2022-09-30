<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\AnimalService;
use App\Services\AdminService;
use App\Http\Controllers\AnimalController;


class AdminController extends Controller
{
    protected $animalService;
    protected $animals;
    protected $adminService;

    public function __construct()
    {
        $this->animalService = new AnimalService();
        $this->adminService = new AdminService();
        $this->animals = new AnimalController();

    }
    //Get page
    public function index()
    {
        $animals_arr = $this->animalService->dataForMainNavPanel();
        $animals = $this->animals->all();

        return view('admin.main', [
                                    'animals_arr' => $animals_arr,
                                    'animals' => $animals
        ]);
    }
    //
    public function all(Request $request)
    {
        $queryCondition = $this->adminService->makeQueryCondition($request);

        $data = DB::table(DB::raw("(SELECT brand_id, animal_id, product_type_id, id, name, image_path, price FROM products $queryCondition) as res"))
                            ->select('res.*', 'brands.name AS brand', 'animals.name AS animal', 'product_types.name AS type')                
                            ->leftJoin('brands', 'res.brand_id', '=', 'brands.id')
                            ->leftJoin('animals', 'res.animal_id', '=', 'animals.id')  
                            ->leftJoin('product_types', 'res.product_type_id', '=', 'product_types.id')   
                            ->orderBy('animal', 'DESC')->orderBy('type', 'DESC')
                            ->get()->toArray();

        $arrResult = $this->adminService->prepareResult($data);

        return $arrResult;
    }
}
