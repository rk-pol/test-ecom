@extends('layouts.app')

@section('content')
<section>       
   <div class="flex">
    @include('main.admin.part-templates.admin-nav')
    <div class="flex flex-dr-col admin-content">
        <div class="flex flex-jst-c admin-ctrl-panel">
            <span>All countries</span>
        </div>  
        {{-- Add new country --}}
        <div class="new-country flex flex-abs-c">
                <form action="{{ URL()->current() . '/create' }}" method="POST">
                    @csrf
                    <span class="@error('new_country') err-text-color @enderror">
                        New country: 
                    </span>
                    <input type="text" class="new-country-title" name="new_country">
                    <input type="submit" value="Add" class="btn-add-country">
                </form>        
        </div>  
         {{-- Display errors --}}
         <div class="err-dislpay err-text-color">
            @if($errors->any())
            {!! implode('', $errors->all('<div>:message</div>')) !!}
        @endif
        </div>
        <hr>
        {{-- Loop countries from DB --}}
        <div class="admin-field">
            @if (isset($countries))
                @forelse ($countries as $country)
                    <div class="flex flex-spc-btw flex-align-c">       
                        <div class="country-field">
                            <span data="{{ $country->id }}">{{ $country->country }}</span>
                        </div>
                        <div class="flex flex-spc-btw action-field">  
                            <form action="{{ URL()->current() . '/delete'}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <input type="hidden" name="id_country" value="{{  $country->id }}">
                                <input type="submit"  class="btn-del" id="del_country" value="Delete">
                            </form>
                        </div>  
                    </div>
                    <hr class="hr-adm">       
                    @empty
                    <div class="emptyData">
                        <h3>Countries are empty</h3>
                    </div>                      
                    @endforelse 
            @endif        
        </div>
    </div>   
    </div>  
   </section>
@endsection