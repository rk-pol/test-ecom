@extends('layouts.app')

@section('content')
    
<section class="flex flex-align-c">
   <div class="flex main-wrap-category">
    {{-- Add nav panel --}}
    @include('main.admin.part-templates.admin-nav')
    {{-- Add main content --}}
    <div class="flex flex-dr-col admin-content">
        <div class="flex flex-jst-c admin-ctrl-panel">
            <span>Animals</span>
        </div>  
        {{-- Add new category --}}
        <div class="new-category flex flex-align-end ">
            <div class="wrap-category-create-btn">
                <form action="{{ URL()->current() . '/create' }}">
                    <button type="submit"  id="create_animal">Create</button>
                    <input type="hidden" name="category_id" >
                </form>
            </div>
            <div class="flex flex-jst-c" style="flex-grow: 1">
                <span class="@error('new_category') err-text-color @enderror">
                    Select category: 
                </span>
                <select name="category_id">
                    @foreach ( $categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                    @endforeach    
                </select>
                <input type="button" value="Select" class="btn-select-category">
            </div>                
        </div>  
        <hr>
        {{-- Display errors --}}
        <div class="err-dislpay err-text-color">
            @if($errors->any())
                {!! implode('', $errors->all('<div>:message</div>')) !!}
            @endif
        </div>
        {{-- Loop animals from DB --}}
        

        <div class="admin-field admin-field-display flex flex-spc-ard flex-align-c">
                  
    </div>  
   </section>

@endsection