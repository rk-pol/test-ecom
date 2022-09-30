<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CookieController;
use App\Http\Requests\OrderRequest;
use App\Services\AnimalService;
use App\Models\Cart;

class CartController extends Controller
{
    protected $cookies;
    protected $products;

    public function __construct()
    {
        $this->cookies = new CookieController(); 
        $this->products = new ProductController();

    }
    //
    private function getUserUuid($request)
    {

       if ($request->user()) {

            return [
                    'name' => 'user_id',
                    'value' => $request->user()->id
            ];

       } else {

            return [
                    'name' => 'p_uuid',
                    'value' => $this->cookies->checkCookie($request)
                ];

        }

    }
    //
    public function store(Request $request)
    {
        
        $price = $this->products->get($request->product_id)->price;

        $uuid = $this->getUserUuid($request);
        
        $data = Cart::create([
            'product_id' => $request->product_id,
            $uuid['name'] => $uuid['value'],
            'amount' => $request->amount,
            'price' => $price
        ]);

        return $data;  
    }
    //
    public function delete(Request $request)
    {         
        if ($p_uuid = $this->cookies->checkCookie($request)) {
            Cart::where('p_uuid', $p_uuid)->where('product_id', $request->id)->delete();
        } else {
            Cart::where('user_id', $request->user()->id)->where('product_id', $request->id)->delete();
        } 
        
    }
    //
    public function all(Request $request)
    {
        $uuid = $this->getUserUuid($request);

        $result = Cart::select('cart.*', 'products.name', 'products.image_path', 'products.short_description')
                            ->where($uuid['name'], $uuid['value'])
                            ->leftjoin('products', 'products.id', '=', 'cart.product_id')
                            ->get();
                           
        return $result;

    }
    //
    public function check(Request $request)
    {   

        $uuid = $this->getUserUuid($request);

        $result = DB::table('cart')
                        ->select(DB::raw("SUM(price * amount) as price, SUM(amount) as amount"))
                        ->where($uuid['name'], $uuid['value'])
                        ->groupBy('user_id')
                        ->get();

        $products = DB::table('cart')
                          ->select('*')
                          ->where($uuid['name'], $uuid['value'])
                          ->get();                      
        
        return [$result, $products];
    }
    //
    public function get(Request $request)
    {
        $uuid = $this->getUserUuid($request);

        $product = Cart::where($uuid['name'], $uuid['value'])
                        ->where('product_id', $request->id)
                        ->get();

        return $product;
    }
    //
    public function incrementAmount(Request $request)
    {
        $uuid = $this->getUserUuid($request);

        Cart::where($uuid['name'], $uuid['value'])
                ->where('product_id', $request->id)
                ->increment('amount', $request->amount);
                        
        return $this->get($request);
    }
    //
    public function decrementAmount(Request $request)
    {
        $uuid = $this->getUserUuid($request);

        Cart::where($uuid['name'], $uuid['value'])
                ->where('product_id', $request->id)
                ->decrement('amount', $request->amount);

        return $this->get($request);
    }
    //
    public function update(Request $request)
    {
        $uuid = $this->getUserUuid($request);

        Cart::where($uuid['name'], $uuid['value'])
                ->where('product_id', $request->id)
                ->update(['amount' => $request->amount]);

        return $this->get($request);
    }
    //
    public function makeOrder(
                                AnimalService $animal_service,
                                BrandController $brands,
                                AnimalController $animals,
                                ProviderController $providers
    ) {

        $animals_arr = $animal_service->dataForMainNavPanel();
        $brands = $brands->all();
        $animals = $animals->all();
        $providers = $providers->all();

        return view('products.order_page', [    
                                    'animals_arr' => $animals_arr,
                                    'providers' => $providers,
                                    'animals' => $animals,
                                    'brands' => $brands
        ]);
    }
    //
    public function orderProcess(OrderRequest $request)
    {
        $uuid = $this->getUserUuid($request);

        Cart::where($uuid['name'], $uuid['value'])->delete(); 

        return redirect('/');
    }
}
