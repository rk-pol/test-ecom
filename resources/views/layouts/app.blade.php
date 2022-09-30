<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Tailwind  -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
        {{-- Swiper --}}
        <link  rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
    </head>
    <body>

        @include('layouts.cart')

        @include('layouts.header')
        
        @include('main.categories_nav')
             
        @yield('content')
    
        @include('layouts.footer')

        @include('layouts.preloader')

        @include('layouts.modal-status')
      
    </body>
    {{-- Global params --}}
    <script>
        var imgPath = "{{ asset('')}}";
        var animalPath = "{{ URL()->current()}}";
        var _token = '@csrf';
    </script>
    {{-- Preloader --}}
    <script>
        window.onload = function () {
          document.body.classList.add('loaded_hiding');
          window.setTimeout(function () {
            document.body.classList.add('loaded');
            document.body.classList.remove('loaded_hiding');
          }, 300);
        }
      </script>
    {{-- JS --}}
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
   {{-- My Jquery --}}
    <script src="{{ asset('assets/js/main.js') }}"> </script>
    {{-- Swiper --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.2/js/swiper.min.js"></script>
    {{-- Validator Form--}}
    {{-- <script src="/assets/js/validate.js"></script> --}}
    {{-- Validator --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
</html>
<img src="" alt="">