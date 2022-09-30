@extends('layouts.app')


@section('content')

<section class="main-section flex flex-abs-c flex-dr-col">
    <div class="login-wrap flex flex-dr-col">
        <div class="form-title flex flex-abs-c">
            <span>Registration</span>
        </div>
        <form action="{{ route('registerProcess') }}" method="post">
            @csrf
            <div class="login-data-wrap flex flex-dr-col flex-abs-c">
                <div class="login-data flex flex-dr-col flex-abs-c flex-spc-ard">
                    <div class="login-field login-login flex flex-spc-ard ">
                        <input type="text" name="name" id="name" placeholder="Login">                        
                    </div>
                    @error('name')
                            <p class="err-text-color">{{ $message }}</p>
                        @enderror
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
                    <div class="login-field login-confirm-password flex flex-spc-ard ">
                        <input type="password" name="password_confirmation" id="password" placeholder="Password">                    
                    </div>
                    @error('password_confirmation')
                        <p class="err-text-color">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="login-addition flex flex-abs-c">
                <div class="">
                    <a href="{{ route('login') }}">
                        All ready registrated?
                    </a>
                </div>
            </div>
            <div class="login-btn-wrap flex flex-abs-c">
                <div class="login-btn">
                    <input type="submit" value="Registrate">
                </div>              
            </div>
        </form>
    </div>
       
</section>  
@endsection