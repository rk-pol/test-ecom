@extends('layouts.app')

@section('content')
<section>
    <div id="modal" class="modal-title">
        <div id="modal__overlay"></div>
            <div id="modal__window">
                    <div class="modal-content flex flex-dr-col flex-spc-ard">
                        <div class="modal-content-input flex">
                            <span class="categ-title" id="old_category">Old name: </span>
                            <input type="text" class="modal-input" name="old_category">
                        </div>
                        <div class="modal-content-input flex">
                            <span class="categ-title" id="new_category">New name: </span>   
                            <input type="text" class="modal-input" name="new_category" data="">
                        </div>                                         
                    </div>
                    
                    <div class="btn-modal-confirm-wrap flex flex-spc-btw">
                        <input type="file" id="category_img" name="img_file">
                        <button type="button" class="btn-modal-confirm">Confirm</button>
                    </div>
            </div>
    </div>
    <div id="modal" class="modal-img">
            <div id="modal__window_img">
                <img class="img-category" src="" alt="">
                </div>
        </div>   
   <div class="flex">
    {{-- Add nav panel --}}
    @include('main.admin.part-templates.admin-nav')
    {{-- Add main content --}}
    <div class="flex flex-dr-col admin-content">
        <div class="flex flex-jst-c admin-ctrl-panel">
            <span>All categories</span>
        </div>  
        {{-- Add new category --}}
        <div class="new-category flex flex-abs-c">
                <form action="{{ URL()->current() . '/create' }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <span class="@error('new_category') err-text-color @enderror">
                        New category: 
                    </span>
                    <input type="text" class="new-category-title" name="new_category">
                    <input type="file" id="img-input" name="img_file">
                    <input type="submit" value="Add" class="btn-add-category">
                </form>        
        </div>  
        <hr>
        {{-- Display errors --}}
        <div class="err-dislpay err-text-color">
            @if($errors->any())
            {!! implode('', $errors->all('<div>:message</div>')) !!}
        @endif
        </div>
       
        {{-- Loop categories from DB --}}
        <div class="admin-field">
            @if (isset($categories))
                @forelse ($categories as $category)
                    <div class="flex flex-spc-btw flex-align-c">       
                        <div class="category-field">
                            <img src="{{ asset('assets/img/min_placeholder.png')}}" class="min-img-placeholder" alt="">
                            <input type="hidden" value="{{ $category->img_path }}">
                            <span data="{{ $category->id }}">{{ $category->category }}</span>  
                        </div>
                        <div class="flex flex-spc-btw action-field">
                            {{-- For edition is Ajax handler --}}
                            <button type="button" class="btn-edit" id="edit_category" data="{{ $category->id }}">
                                Edit
                            </button>   
                            <form action="{{ URL()->current() . '/delete'}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <input type="hidden" name="id_category" value="{{  $category->id }}">
                                <input type="submit"  class="btn-del" id="del_category" value="Delete">
                            </form>                  
                        </div>  
                    </div>
                    <hr class="hr-adm">       
                    @empty
                    <div class="emptyData">
                        <h3>Categories are empty</h3>
                    </div>                      
                    @endforelse 
            @endif        
        </div>
    </div>   
    </div>  
   </section>
@endsection