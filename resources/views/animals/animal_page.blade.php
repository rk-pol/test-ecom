@extends('layouts.app')

@section('content')
<section class="main-section-animal">
    <?php $count = 0;?>
        <div class="animal-category-wrap">
            @foreach ($animal_product_types as $product_type)       
                @if ($count == 0)
                    <div class="flex flex-spc-ard">
                @endif    
                <div class='flex flex-dr-col flex-abs-c current_category'>
                    <a href="{{ URL()->current() . '/' . $product_type->name }}">
                        <img class="category_icon" src='{{ asset("$product_type->image_path") }}'>
                    </a>
                    <span class="category_icon_title">
                        <?= Str::ucfirst($product_type->name)?>
                    </span>
                </div>   
                <?php $count += 1; ?>     
                @if ($count == 4)
                    </div>
                    <?php $count = 0; ?>
                @endif         
            @endforeach 
            </div>  
        </div>

    <div class="flex flex-jst-start flex-abs-c sort">
        <div class="products-sort flex ">
            <span>Sort by:</span>
            <form action="{{ URL()->current() }}">
                <select name="sortBy" >
                    <option value="price_ASC">Price ASC</option>
                    <option value="price_DESC">Price DESC</option>
                    <option value="id_DESC">ID DESC</option>
                </select>
            </form>
            <input type="hidden" name="animal_name" value="{{ $animal }}">
        </div>
    </div>
    <div class="paginate-wrap">
        <div class="flex flex-jst-c">
            {{ $animal_products->links() }}
        </div>
    </div> 
    <div class="category-products-wrap flex flex-dr-col flex-jst-c">  
        <?php $count = 0; $maxProd = count($animal_products);?>
        @foreach ($animal_products as $product)       
            @if ($count == 0)
            <div class="category-product-wrap flex flex-spc-btw"> 
            @endif                                       
                <div class="product">  
                <div class="products-img-wpar">
                    <a href="{{ URL()->current() . '/' . $product->product_type . '/' . $product->id }}">
                          <img class="products-img" src="{{$product->image_path ? asset($product->image_path) : asset('assets/img/main/placeholder.png') }}">
                    </a>    
                </div>
                <div class="product-info">
                    <div class="flex flex-abs-c product-short-description">
                        <a href="{{ URL()->current() . '/' . $product->product_type . '/' . $product->id }}">
                            <p>{{ $product->short_description }}</p>
                        </a>
                        
                    </div>
                     <hr>
                    <div class="product-price flex flex-jst-c">
                        <span id="price_value">{{ $product->price }}</span> 
                        <span class="price-currency">USD</span>
                    </div>
                    <div class="product-button">
                        <input type="button" value="Add">
                        <input type="hidden" name="hidden_info" animal="{{ $product->animal }}" prod_type="{{ $product->product_type }}" prod_id="{{ $product->id }}">
                    </div>
                </div>
                </div>
            <?php $count+=1; ?> 
              
             @if ($count == 4)
                </div>
                <?php $count = 0; ?>
            @elseif ($maxProd == $loop->iteration)
                 </div>
            @endif         
        @endforeach        
    </div>    
</section>

@endsection