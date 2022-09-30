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
    <div class="flex main-wrap-product flex-jst-c"> 
    {{-- Add nav panel --}}
    @include('admin.part-templates.admin-nav') 
        <div class="flex flex-dr-col flex-align-c prod-new-wrap hd_elem ">
            <div class="title-admin-create">
                <span>Edit product</span>
            </div>
            <hr>
            <div class="animal-img-info flex ">
                <div class="animal-img-new-wrap ">
                    <div class="animal-img-new flex flex-jst-c">
                        <img src="{{ asset($product->image_path??'assets/img/main/placeholder.png') }}" alt="" class="img-placeholder">
                    </div>
                    <input type="file" name="product_img" id="product_img">
                </div>
                <div class="flex flex-abs-c">
                    <div class="flex flex-dr-col">
                        <table id="cr_pr_tbl">
                            <tr>
                                <td><span>Product name: </span> </td>
                                <td>
                                    <input type="text" name="name" value="{{ $product->name }}">
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <span class="elem-hidden textErr"></span>
                                </td>
                                
                            </tr>
                            <tr>
                                <td><span>Product articul: </span> </td>
                                <td>
                                    <input type="text" name="articul" value="{{ $product->articul }}">
                                    <span class="elem-hidden textErr"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span>Animal: </span></td>
                                <td>
                                    <select class="cr-prod-sl" name="animal_id" id="cr_prod_animal">
                                        <option value="null" disabled></option>
                                        @foreach ($animals as $animal)
                                            @if ($product->animal_id == $animal->id)
                                                <option value="{{ $animal->id }}" selected disabled>{{ ucfirst($animal->name) }}</option>
                                                @continue
                                            @endif
                                            <option value="{{ $animal->id }}" disabled>{{ ucfirst($animal->name) }} </option>
                                        @endforeach
                                </select>
                                <span class="elem-hidden textErr"></span>
                            </td>
                            </tr>
                            <tr>
                                <td><span>Brand: </span></td>
                                <td>
                                    <select  name="brand_id" id="cr_prod_brand">
                                        <option value="null" disabled></option>
                                        @foreach ($brands as $brand)
                                            @if ($product->brand_id == $brand->id)
                                                <option value="{{ $brand->id }}" selected disabled>{{ $brand->name }}</option>
                                                @continue
                                            @endif
                                            <option value="{{ $brand->id }}" disabled>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="elem-hidden textErr"></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span>Category: </span></td>
                                <td>
                                    <select name="product_type_id" id="cr_prod_category">
                                        <option value="null" disabled></option>
                                        @foreach ($categories as $category)
                                            @if ($product->product_type_id == $category->id)
                                                @php
                                                    $selected_category = $category->name;
                                                @endphp
                                                <option value="{{ $category->id }}" selected disabled>{{Str::ucfirst($category->name) }}</option>
                                                @continue
                                            @endif
                                            <option value="{{ $category->id }}" disabled>{{ ucfirst($category->name) }} </option>
                                        @endforeach
                                    </select>
                                <span class="elem-hidden textErr"></span>
                            </td>
                            </tr>
                            <tr>
                                <td><span> Is new: </span></td>
                                <td>
                                    @if ($product->is_new)
                                        <input class="chbox" type="checkbox" name="is_new" value="true" checked>
                                    @else
                                        <input class="chbox" type="checkbox" name="is_new" value="true">
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Additional info about product --}}
            {{-- <hr> --}}
            <div class="prod-main-info flex flex-abs-c flex-dr-col">
                <table id="prod-tbl-price">
                    <tr>
                        <td class="title-prod-info">
                            <span class="title-prod-info-text">
                                Price:
                            </span>
                            <input id="cr_prod_price" type="text" name="price" value="{{ $product->price }}">
                        </td>
                        <td>
                            <div id="priceErr" class="elem-hidden textErr"></div>
                        </td>
                    </tr> 
                </table>
                <hr>
                <table class="prod-new-table">
                    <tbody>    
                        <tr>
                            <td class="title-prod-info">
                                <span class="title-prod-info-text">
                                    Short description:
                                </span>
                            </td>
                            <td class="input-prod-info">
                                <span class="elem-hidden textErr"></span>
                                <textarea name="short_description" class="prod-info-textarea">{{ $product->short_description }}</textarea>
                            </td>
                        </tr>  
                        <tr>
                            <td class="title-prod-info">
                                <span class="title-animal-info-text">
                                    Long description:
                                </span>
                            </td>
                            <td class="input-prod-info">
                                <span class="elem-hidden textErr"></span>
                                <textarea name="long_description" class="prod-info-textarea">{{ $product->long_description }}</textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                {{-- // --}}
                <div class="prod-parameters">
                    @if ($selected_category == 'toies')
                    <div class="prod-param" id="toies">
                        <table>
                            <tr>
                                <td id="#tbl_title_prod_param">
                                    <span id="#tbl_title_prod_param">Type: </span>
                                </td>
                                <td>
                                    <input type="text" name="t_type" value="{{ empty($details->type)?'':$details->type  }}">
                                    <span class="elem-hidden textErr"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span id="#tbl_title_prod_param">Dimensions:</span>
                                </td>
                                <td>
                                    <input type="text" name="dimension">
                                    <span class="elem-hidden textErr">{{ empty($details->dimension )?'':$details->dimension }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span id="#tbl_title_prod_param">Material:</span>
                                </td>
                                <td>
                                    <input type="text" name="material" value="{{ empty($details->material )?'':$details->material }}">
                                    <span class="elem-hidden textErr"></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    @elseif ($selected_category == 'feed')
                    <div class="prod-param" id="feed">
                        <table>
                            <tr>
                                <td>
                                    <span id="#tbl_title_prod_param">Type: </span>
                                </td>
                                <td>
                                    <input type="text" name="f_type" value="{{ empty($details->type)?'':$details->type}}">
                                    <span class="elem-hidden textErr"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span id="#tbl_title_prod_param">Age: </span>
                                </td>
                                <td>
                                    <input type="text" name="f_age" value="{{ empty($details->age)?'':$details->age }}">
                                    <span class="elem-hidden textErr"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span id="#tbl_title_prod_param">Taste:</span>
                                </td>
                                <td>
                                    <input type="text" name="taste" value="{{ empty($details->taste)?'':$details->taste  }}">
                                    <span class="elem-hidden textErr"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span id="#tbl_title_prod_param">Weight:</span>
                                </td>
                                <td>
                                    <input type="text" name="weight" value="{{ empty($details->weight )?'':$details->weight }}">
                                    <span class="elem-hidden textErr"></span>
                                </td>
                            </tr>  
                        </table>
                    </div>
                    @else
                    <div class="prod-param" id="bath">
                        <table>
                            <tr>
                                <td>
                                    <span id="#tbl_title_prod_param">Type:</span>
                                </td>
                                <td>
                                    <input type="text" name="b_type" value="{{ empty($details->type )?'':$details->type }}">
                                    <span class="elem-hidden textErr"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span id="#tbl_title_prod_param">Age:</span>
                                </td>
                                <td>
                                    <input type="text" name="b_age" value="{{ empty($details->age )?'':$details->age }}">
                                    <span class="elem-hidden textErr"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span id="#tbl_title_prod_param">Weight:</span>
                                </td>
                                <td>
                                    <input type="text" name="p_weight" value="{{ empty($details->weight )?'':$details->weight }}">
                                    <span class="elem-hidden textErr"></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    @endif
                </div>
               <hr>
                <div class="flex flex-abs-c admin-options-btn input">                  
                    <input class="animal-btn" type="submit" value="Edit" id="store_prod_data">
                </div>
            </div>
        </div>
    {{-- Add nav panel --}}
    @include('admin.part-templates.admin-nav_emp') 
    </div>
</section>
@endsection