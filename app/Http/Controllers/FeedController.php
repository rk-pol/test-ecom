<?php

namespace App\Http\Controllers;

use App\Models\Feed;

class FeedController extends Controller
{
    //
    public function store($array)
    {
        return Feed::create($array);      
    }
    //
    public function update($id, $array)
    {
        Feed::find($id)->update($array);
    }
    //
    public function get($id)
    {
        return Feed::find($id);
    }
    //
    public function getByProductId($id)
    {
        return Feed::where('product_id', $id)->get();
    }
    //
    public function updateByProductId($id, $array)
    {
        Feed::where('product_id', $id)->update($array);
    }
}
