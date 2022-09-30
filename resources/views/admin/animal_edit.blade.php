@extends('layouts.app')

@section('content')
<section>
    <div class="flex main-wrap-category">
        {{-- Add nav panel --}}
        @include('main.admin.part-templates.admin-nav')
        <form action="{{ URL('admin/animals/update') }}"  method="POST" enctype="multipart/form-data" class="form-animal-edit">
            @csrf
        <div class="flex flex-dr-col flex-align-c animal-new-wrap">
            <div class="animal-img-new-wrap ">
                <div class="animal-img-new flex flex-jst-c">
                    <img src="{{ asset("$animal->img_path") }}" alt="" class="img-placeholder">
                </div>
                <input type="file" name="animal_img" id="animal_img">
            </div>
            <div class="animal-main-info flex flex-abs-c flex-dr-col">
               <input type="hidden" name="animal_id" value="{{ $animal->id }}">
                <table class="animal-new-table">
                    <tbody>
                        <tr>
                            <td class="title-animal-info">
                                <span class="title-animal-info-text" >
                                    Country:
                                </span>
                            </td>
                            <td class="input-animal-info">
                                <select name="id_country" id="animal_country_select">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" {{ ($country->id == $animal->id_country) ? 'selected' : '' }}>{{ $country->country }}</option>                                        
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="title-animal-info">
                                <span class="title-animal-info-text">
                                    Category:
                                </span>
                            </td>
                            <td class="input-animal-info">
                                <input type="text" name="category_name" class="animal-info-input" value="{{ $category->category }}" data="{{ $category->id }}" readonly>
                            </td>
                        </tr>        
                        <tr>
                            <td class="title-animal-info">
                                <span class="title-animal-info-text">
                                    Species name:
                                </span>
                            </td>
                            <td class="input-animal-info">
                                <input type="text" name="species_name" class="animal-info-input" value="{{ $animal->species_name }}">
                            </td>
                        </tr>  
                        <tr>
                            <td class="title-animal-info">
                                <span class="title-animal-info-text">
                                    Description:
                                </span>
                            </td>
                            <td class="input-animal-info">
                                <textarea name="description" class="animal-info-textarea" >{{ $animal->description }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="title-animal-info">
                                <span class="title-animal-info-text">
                                    Origin:
                                </span>
                            </td>
                            <td class="input-animal-info">
                                <textarea name="origin" class="animal-info-textarea" >{{ $animal->origin }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="title-animal-info">
                                <span class="title-animal-info-text">
                                    Temper:
                                </span>
                            </td>
                            <td class="input-animal-info">
                                <textarea  name="temper" class="animal-info-textarea" >{{ $animal->temper }}</textarea>
                            </td>
                        </tr>                         
                    </tbody>
                </table>
                <div class=""> 
                    
                        <input type="submit" value="Update" id="update_animal">
                                                    
                </div>
            </div>
        </div>
    </form>  
    </div>
</section>
@endsection