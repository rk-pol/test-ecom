@extends('layouts.app')

@section('content')
<section>
    <div class="flex main-wrap-category">
        {{-- Add nav panel --}}
        @include('main.admin.part-templates.admin-nav')
        <div class="flex flex-dr-col flex-align-c animal-new-wrap">
            <div class="animal-img-new-wrap ">
                <div class="animal-img-new flex flex-jst-c">
                    <img src="{{ asset('assets/img/placeholder.png') }}" alt="" class="img-placeholder">
                </div>
                <input type="file" name="animal_img" id="animal_img">
            </div>
            <div class="animal-main-info flex flex-abs-c flex-dr-col">
                <table class="animal-new-table">
                    <tbody>
                        <tr>
                            <td class="title-animal-info">
                                <span class="title-animal-info-text" >
                                    Country:
                                </span>
                            </td>
                            <td class="input-animal-info">
                                <select name="country_id" id="animal_country_select">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->country }}</option>                                        
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
                                <input type="text" name="category" class="animal-info-input" value="{{ $category->category }}" data="{{ $category->id }}" readonly>
                            </td>
                        </tr>        
                        <tr>
                            <td class="title-animal-info">
                                <span class="title-animal-info-text">
                                    Species name:
                                </span>
                            </td>
                            <td class="input-animal-info">
                                <input type="text" name="species" class="animal-info-input">
                            </td>
                        </tr>  
                        <tr>
                            <td class="title-animal-info">
                                <span class="title-animal-info-text">
                                    Description:
                                </span>
                            </td>
                            <td class="input-animal-info">
                                <textarea name="description" class="animal-info-textarea"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="title-animal-info">
                                <span class="title-animal-info-text">
                                    Origin:
                                </span>
                            </td>
                            <td class="input-animal-info">
                                <textarea name="origin" class="animal-info-textarea"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="title-animal-info">
                                <span class="title-animal-info-text">
                                    Temper:
                                </span>
                            </td>
                            <td class="input-animal-info">
                                <textarea  name="temper" class="animal-info-textarea"></textarea>
                            </td>
                        </tr>                         
                    </tbody>
                </table>
                <div class="">
                    
                    <input type="submit" value="Create" id="store_animal">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection