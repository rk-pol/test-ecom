@extends('layouts.app')

@section('content')
    
<section class="flex flex-jst-c flex-align-start home-section">  
        <div class="home-field flex flex-spc-btw ">           
            @foreach ($array_animals as $animal)
                <div id="foo" class="img-wrap flex flex-dr-col flex-align-c">
                    <span class="species-title">{{ $animal->species_name }}</span>
                    <a href="{{ URL()->current() . '/'}}<?php echo str_replace(' ', '-', trim($animal->species_name));?>">                      
                        <img src="{{ asset("$animal->img_path") }}" class="img-placeholder">
                    </a>                   
                </div>
            @endforeach 
        </div>
</section>

@endsection