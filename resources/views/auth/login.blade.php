@extends('layouts.app')


@section('content')

<section class="main-section flex flex-abs-c flex-dr-col">
    <div class="login-wrap flex flex-dr-col">
        <div class="form-title flex flex-abs-c">
            <span>Login</span>
        </div>
        <form action="{{ route('loginProcess') }}" method="post">
            @csrf
            <div class="login-data-wrap flex flex-dr-col flex-abs-c">
                <div class="login-data flex flex-dr-col flex-abs-c flex-spc-ard">
                    <div class="login-field login-email flex flex-spc-ard ">
                        <input type="email" name="email" id="email" placeholder="Email">
                    </div>
                    @error('email')
                        <p class="err-text-color">{{ $message }}</p>
                    @enderror
                    <div class="login-field login-password flex flex-spc-ard ">
                        <input type="password" name="password" id="password" placeholder="Password">
                    </div>
                    @error('password')
                        <p class="err-text-color">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="login-addition flex flex-spc-btw">
                <div class="">
                    <a href="{{ route('restore') }}">
                        Forget password?
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
                    <input type="submit" value="Login">
                </div>              
            </div>
        </form>
    </div>   
</section>  
@endsection