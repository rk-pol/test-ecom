@extends('layouts.app')


@section('content')
<section class="main-section flex flex-dr-col flex-align-c">
    <div class="product-info-main-wrap flex flex-spc-ard">
        <div class="product-imfo-main-img flex flex-abs-c">
            <img src="{{$product->image_path ? asset($product->image_path) : asset('assets/img/main/placeholder.png') }}" alt="">
        </div>
        <div class="product-info-main flex flex-dr-col">
            <h2>{{ $product->name }} </h2>
            <h4>Articul: {{ $product->articul  }}</h4>
            <h4>Brand: {{ $product->brand }}</h4>
            <div class="product-info-single flex flex-dr-col">
                <div class="product-info-single-price flex flex-align-c flex-align-start">
                    <span>Price: </span> 
                    <span id='prod_price'>{{ $product->price }}</span>
                    <input type="hidden" name="base_price" value="{{ $product->price }}">
                    <span id="price_currency">USD</span>
                </div>      
                <hr>     
                 <div class="product-info-single-count flex flex-align-c flex-align-start">
                    <span>Amount:</span>
                    <div class="plus-minus-count flex flex-spc-btw flex-align-c">
                        <img class="plus-minus-count-minus pm_img" src="{{ asset('assets/img/Main/_minus.png') }}" alt="">
                        <input type="text" name="quantity" class="plus-minus" value="1" >
                        <img class="plus-minus-count-plus pm_img" src="{{ asset('assets/img/Main/_plus.png') }}" alt="">

                    </div>  
                 </div>
                 <hr>
                 <div class="product-info-single-btn flex flex-abs-c ">
                    <input type="button" value="Add">
                    <input type="hidden" name="info_prod" prod_id="{{ $product->id }}">
                 </div>
            </div>
        </div>
    </div>
    <div class="product-info-desc">
        <div class="tabs-block-wrapper">
			<div id="tabs">
				<button type="button" class="tab__btn active" data-btn="1">Description</button>
				<button type="button" class="tab__btn " data-btn="2">Details</button>
			</div>
			<div id="contents">
				<div class="content active" data-cont="1">
					<p class="content__text"> {{ $product->long_description }}
					</p>
				</div>
				<div class="content flex flex-dr-col" data-cont="2">
                    @if ($details)
                        @foreach ( $details as $name =>$value)
                        <div class="product_detail flex flex-spc-btw">
                            <div class="product-detail-name">
                                <span>{{Str::ucfirst($name) }}:</span>
                            </div>                    
                            <div class="product-detail-val">
                                <span>{{ $value }}</span>
                            </div>   
                        </div> 
                        <hr>   
                        @endforeach
                    @endif
                  
				</div>
			</div>
		</div>
    </div>
</section>
@endsection