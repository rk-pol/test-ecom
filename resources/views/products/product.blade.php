@extends('layouts.app')


@section('content')
<section class="flex flex-dr-col">
    <div class="product-info-main-wrap">
        <div class="product-imfo-main-img">
            <img src="{{ asset('assets/img/main/placeholder.png') }}" alt="">
        </div>
        <div class="product-info-main flex flex-dr-col">
            <h2>Product name</h2>
            <div class="flex flex-dr-col">                 
            </div>
        </div>
    </div>
    <div class="product-info-desc"></div>
</section>
@endsection