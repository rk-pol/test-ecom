@extends('layouts.app')

@section('content')
<section class="main-section-admin flex flex-jst-c">
    {{-- Add nav panel --}}
    @include('admin.part-templates.admin-nav')
    
    <div class="admin-options-wrap">
       <div class="admin-options-main flex flex-dr-col">
            <div class="admin-options flex flex-jst-spc-ev flex-align-c">
                <div class="">
                    <span>Animal:</span>
                    <select name="animals" id="select_animal">
                        <option value="null"></option>
                        @foreach ($animals as $animal)
                            <option value="{{ $animal->id }}">{{ $animal->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="">
                    <span>Brand:</span>
                    <select name="brands" id="select_brand">
                        <option value="null"></option>
                    </select>
                </div>
                <div class="">
                    <span>Product's category:</span>
                    <select name="categories" id="select_category">
                        <option value="null"></option>
                    </select>
                </div>
            </div>
            <div class="admin-options-btn flex flex-jst-c">
                <input type="button" value="Search">
            </div>    
       </div>
       <hr>   
     <div class="result-tbl-head-wrap">
        <div id="text_result">RESULT</div>
        <div class="result-tbl-values"></div>
    </div>
    </div>
    {{-- Add nav panel --}}
    @include('admin.part-templates.admin-nav_emp') 
   </section>

    @endsection