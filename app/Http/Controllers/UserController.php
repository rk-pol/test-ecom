<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{  
    public function store($array)
    {
        User::create($array);
    }
    //Get all products from cart by UUID
    public function getItemsCartUuid(Request $request)
    {
        $products = DB::table('cart')
                        ->select('*')
                        ->where('users_uuid', $request->_uuid)
                        ->get();

        return $products;
    }
    //
    public function addInCart(Request $request)
    {
        DB::table('cart')->insert([
                            'users_uuid' => $request->_uuid,
                            'product_id' => $request->id
        ]);

    }
}

