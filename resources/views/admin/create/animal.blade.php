@extends('layouts.app')

@section('content')

<section class="main-section-admin">
   
    <div id="modal" class="modal-editcateg">
        <div id="modal__overlay"></div>
            <div id="modal__window">
                    <div class="modal-content flex flex-dr-col flex-spc-ard">
                        <div class="modal-content-input flex">
                            <span class="categ-title" id="mw_old_category">Old name: </span>
                            <input type="text" class="modal-input" name="mw_old_category">
                        </div>
                        <div class="modal-content-input flex">
                            <span class="categ-title" id="mw_new_category">New name: </span>   
                            <input type="text" class="modal-input" name="mw_new_category" data_id="">
                        </div>                                         
                    </div>
                    
                    <div class="btn-modal-confirm-wrap flex flex-jst-c">
                        <button type="button" class="btn-modal-confirm">Confirm</button>
                    </div>
            </div>
    </div>
    <div class="flex">
        {{-- Navigation part --}}
        @include('admin.part-templates.admin-nav')
        {{-- // --}}
        <div class="main-animal hd_elem flex flex-dr-col flex-align-c">
            <div class="title-admin-create flex flex-abs-c">
                <span>New animal</span>
            </div>
            <hr>
            <div class="cr-animal-nav flex flex-spc-ard">
                {{-- // --}}
                <div class="flex flex-dr-col">
                    <table class="cr-animal-tbl-wrap">
                        <tr>
                            <td>
                                <span id="cr-title">Create a new animal: </span>
                            </td>
                            <td class="pos-rel">
                                <input id="new_animal" type="text">
                                <div class="errWrap"><span class="elem-hidden textErr"></span></div>
                            </td>
                            <td>
                                <input class="create-btn" data_name="animals" type="button" value="Create">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span id="cr-title">Create a new category: </span>
                            </td>
                            <td class="pos-rel"> 
                                <input id="new_category" type="text">
                                <div class="errWrap"><span class="elem-hidden textErr"></span></div>
                            </td>
                            <td>
                                <input class="create-btn" type="button" data_name="categories" value="Create">
                            </td>
                        </tr>
                    </table>               
                </div>
                {{-- // --}}
                <div class="cr-new-animal flex flex-dr-col">
                    <table class="cr-animal-tbl-wrap">
                        <tr>
                            <td>
                                <span id="cr-title">Show all animals: </span>
                            </td>
                            <td>
                                <input class="show-btn" data_name="animals" type="button" value="Show">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span id="cr-title">Show all categories: </span>
                            </td>
                            <td>
                                <input class="show-btn" data_name="categories" type="button" value="Show">
                            </td>
                        </tr>
                    </table>
                </div>
                {{-- // --}}
                <div class="flex">     
                    <table>
                        <tr>
                            <td>
                                <span id="cr-title">Make new dependence: </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span id="cr-title">Animal: </span>
                            </td>
                            <td>
                                <select class="cr-sl" id="cr-animal-sl" name="animals">
                                    <option value="null"></option>
                                    @foreach ($animals as $animal)
                                        <option value="{{ $animal->id }}">{{ $animal->name }}</option>
                                    @endforeach
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span id="cr-title">Category:</span>
                            </td>
                            <td>
                                <select class="cr-sl" id="cr-category-sl" name="categories"> 
                                    <option value="null"></option>
                                    @foreach ($product_types as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach 
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="cr-create-btn-make">
                                    <input class="make-depen-btn" data_dep="an-cat" type="button" value="Make">
                                </div>
                            </td>
                            <td>
                                <input type="file" name="image_file">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>    
            <hr>
            <div class="cr-animal-wrap">
                <div class="flex flex-jst-c"><span>RESULT</span></div>
                <div class="res-title flex flex-jst-c"><span></span></div>
                <div class="cr-animal-rest-wrap flex flex-spc-btw">
                    <div class="cr-animal-res-title-wrap">
                        <div class="cr-animal-res-title flex flex-spc-btw">
                            <span>ID</span>
                            <span>Name</span>
                        </div>
                    </div>
                    <div class="cr-animal-res-EdDel flex flex-spc-btw">
                        <span>Edit</span>
                        <span>Delete</span>
                    </div>
                </div>
               <hr>
               <div class="res-to-clear">
                <div class="cr-animal-res-wrap flex">
                    <div class="cr-animal-res-data-wrap">
                        <div class="cr-animal-res-data">
    
                        </div>
                    </div>
                    <div class="res-btn"></div>
                </div>
               </div> 
            </div>
        </div>
          {{-- Navigation part --}}
          @include('admin.part-templates.admin-nav_emp') 
          {{-- // --}}
    </div>

</section>
<section>
    
</section>
@endsection