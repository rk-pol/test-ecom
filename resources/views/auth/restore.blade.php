@extends('layouts.app')


@section('content')

<section class="main-section flex flex-abs-c flex-dr-col">
    <div class="restore-wrap flex flex-dr-col">
        <div class="form-title flex flex-abs-c">
            <span>Restore password</span>
        </div>
        <form action="{{ route('restoreProcess') }}" method="post">
            @csrf
            <div class="restore-data-wrap flex flex-dr-col flex-abs-c">
                <div class="login-data flex flex-dr-col flex-abs-c flex-spc-ard">
                    <div class="login-field login-email flex flex-spc-ard ">
                        <input type="email" name="email" id="email" placeholder="Email">
                    </div>
                    @error('email')
                        <p class="err-text-color">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="login-addition flex flex-spc-btw">
                <div class="">
                    <a href="{{ route('login') }}">
                        Login
                    </a>
                </div>
                <div class="">
                    <a href="{{ route('register') }}">
                        Registrate
                    </a>
                </div>
            </div>
            <div class="login-btn-wrap flex flex-abs-c">
                <div class="login-btn">
                    <input type="submit" value="Restore">
                </div>              
            </div>
        </form>
    </div>
       
</section>  
@endsection