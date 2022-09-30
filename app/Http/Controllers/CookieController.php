<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CookieController extends Controller
{
    protected $cookies;

    public function __construct()
    {
        $this->cookies = Cookie::get('p_uuid');
    }
    //Get coockie
    private function getCookie()
    {
        if ($this->cookies) {
            return $this->cookies;
        }

        return null;
    }
    //Set coockie
    private function setCookie()
    {
        $p_uuid = Str::uuid();

        Cookie::queue('p_uuid', $p_uuid, 120);

        return $p_uuid;
    }
    //Delete coockie
    public function deleteCookie()
    {
        Cookie::forget('p_uuid');
    }
    //
    public function checkCookie(Request $request)
    {
        if (! $this->getCookie($request)) {

            $this->setCookie();

        }
        
        return $this->getCookie($request);
    }
}
