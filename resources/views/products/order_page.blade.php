@extends('layouts.app')


@section('content')
<section class="main-section flex flex-dr-col flex-abs-c">
    <div class="order-wrap flex flex-dr-col">
        <div class="form-title flex flex-abs-c">
            <span>Personal data:</span>
        </div>
        <form action="{{ URL('cart/buy') }}" method="post">
            @csrf
            <div class="order-data-wrap flex flex-dr-col flex-abs-c">
                <div class="order-data flex flex-dr-col flex-abs-c flex-spc-ard">
                    <div class="order-field order-password flex flex-spc-ard ">
                        <input type="text" name="name" id="name" placeholder="Name">
                    </div>
                    @error('name')
                        <p class="err-text-color">{{ $message }}</p>
                    @enderror
                    <div class="order-field order-password flex flex-spc-ard ">
                        <input type="text" name="surname" id="surname" placeholder="Surname">
                    </div>
                    @error('surname')
                        <p class="err-text-color">{{ $message }}</p>
                    @enderror
                    <div class="order-field order-password flex flex-spc-ard ">
                        <input type="text" name="phone" id="phone" placeholder="Phone">
                    </div>
                    @error('phone')
                        <p class="err-text-color">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="order-btn-wrap flex flex-abs-c">
                <div class="order-btn">
                    <input type="submit" value="Buy" id="order_btn">
                </div>              
            </div>
        </form>
    </div>
</section>
@endsection