@extends('layouts.app')


@section('content')

<section class="main-section flex flex-abs-c flex-dr-col">
        <!-- Swiper news-->
        <div class="swiper swiper-news">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                    <!-- Slides -->
                <div class="swiper-slide">
                    <div class="swiper-img-news first"></div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-img-news second"></div>
                </div>
                <div class="swiper-slide">
                    <div class="swiper-img-news third"></div>
                </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        <!-- New products-->
        <div class="new-products-wrap"> 
            <div class="new-products-width flex flex-align-c flex-spc-btw">
                <h2>
                    <i>New products</i>
                </h2>
                <div class="swiper-arrow-wrap flex flex-spc-btw">
                    <div class="swiper-arrow-prev new-products-prev">
                        <img src="{{ asset('assets/img/Main/swiper-img/l_arrow.png') }}" alt="">
                    </div>
                    <div class="swiper-arrow-next new-products-next">
                        <img src="{{ asset('assets/img/Main/swiper-img/r_arrow.png') }}" alt="">
                    </div>
                </div>  
            </div>                   
            <div class="swiper-products-wrap">
                <!-- Navigation buttons -->            
                <div class="swiper swiper-products">                   
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                      <!-- Slides -->
                        @foreach ($new_products as $new_product)
                            <div class="swiper-slide swiper-product">
                                <div class="product-layout">  
                                    <div class="products-img-wpar prod-img-new">
                                    <a href="{{ URL()->current() . '/' . $new_product->animal . '/' . $new_product->product_type . '/' . $new_product->id }}">
                                        <img class="products-img" src="{{ asset($new_product->image_path??'assets/img/products/placeholder.jpg') }}">
                                    </a> 
                                    <span>New</span> 
                                    </div>
                                    <div class="product-info">
                                        <div class="flex flex-abs-c product-short-description">
                                            <a href="{{ URL()->current() . '/' . $new_product->animal . '/' . $new_product->product_type . '/' . $new_product->id }}">
                                                <p>{{ $new_product->short_description }}</p>
                                            </a> 
                                        </div>
                                        <hr>
                                        <div class="product-price flex flex-jst-c">
                                            <span id="price_value">{{ $new_product->price }}</span> 
                                            <span class="price-currency">USD</span>
                                        </div>
                                        <div class="product-button">
                                            <input type="button" value="Add">
                                            <input type="hidden" name="hidden_info" animal="{{ $new_product->animal }}" prod_type="{{ $new_product->product_type }}" prod_id="{{ $new_product->id }}">
                                        </div> 
                                    </div>
                                </div>
                            </div>
                         @endforeach
                    </div>
                </div>    
            </div>
        </div>
        <!-- Swiper hit selling-->
        <div class="hit-products-wrap"> 
            <div class=" hit-product-width flex flex-align-c flex-spc-btw">
                <h2>
                    <i>Hit selling</i>
                </h2>
                <div class="swiper-arrow-wrap flex flex-spc-btw">
                    <div class="swiper-arrow-prev hit-sell-prev">
                        <img src="{{ asset('assets/img/Main/swiper-img/l_arrow.png') }}" alt="">
                    </div>
                    <div class="swiper-arrow-next hit-sell-next">
                        <img src="{{ asset('assets/img/Main/swiper-img/r_arrow.png') }}" alt="">
                    </div>
                </div>  
            </div>          
            <div class="swiper-products-wrap">
                <!-- Navigation buttons -->            
                <div class="swiper swiper-hit-selling">                   
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                    @foreach ($hit_products as $hit_product)
                      <!-- Slides -->
                        <div class="swiper-slide swiper-product">
                                <div class="product-layout">  
                                    <div class="products-img-wpar prod-img-hit">
                                    <a href="{{ URL()->current() . '/' . $hit_product->animal . '/' . $hit_product->product_type . '/' . $hit_product->id }}">
                                        <img class="products-img" src="{{ asset('assets/img/products/placeholder.jpg') }}" alt="" title="" class="">
                                    </a> 
                                        <span>Hit</span>     
                                    </div>
                                    <div class="product-info">
                                        <div class="flex flex-abs-c product-short-description">
                                            <a href="{{ URL()->current() . '/' . $hit_product->animal . '/' . $hit_product->product_type . '/' . $hit_product->id }}">
                                                <p>{{ $hit_product->short_description }}</p>
                                            </a>
                                        </div>
                                        <hr>
                                        <div class="product-price flex flex-jst-c">
                                            <span id="price_value">{{ $hit_product->price }}</span> 
                                            <span class="price-currency">USD</span>
                                        </div>
                                        <div class="product-button">
                                            <input type="button" value="Add" >
                                            <input type="hidden" name="hidden_info" animal="{{ $hit_product->animal }}" prod_type="{{ $hit_product->product_type }}" prod_id="{{ $hit_product->id }}">
                                        </div>
                                    </div>
                                </div>
                        </div>
                    @endforeach    
                    </div>
                </div>    
            </div>
        </div>
        <div class="">
            <div class="about-wrap">
                <div class="flex flex-abs-c home-about">
                    <h1>About</h1>
                </div>
                <hr>
                <div class="home-about-text">
                    <p>Lorem ipsum:</p>
                    <h3>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Volutpat commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend. Volutpat sed cras ornare arcu dui vivamus arcu felis bibendum. Feugiat sed lectus vestibulum mattis ullamcorper velit. Est ante in nibh mauris cursus mattis molestie a. A iaculis at erat pellentesque adipiscing commodo elit at. Turpis egestas integer eget aliquet nibh praesent tristique magna sit. Nullam eget felis eget nunc lobortis mattis aliquam. Elementum pulvinar etiam non quam lacus suspendisse faucibus. Duis tristique sollicitudin nibh sit amet commodo nulla. Diam vel quam elementum pulvinar etiam non quam lacus. Placerat duis ultricies lacus sed turpis. Condimentum mattis pellentesque id nibh tortor id aliquet lectus proin. Quis enim lobortis scelerisque fermentum dui. Rutrum tellus pellentesque eu tincidunt tortor aliquam. Velit ut tortor pretium viverra suspendisse potenti nullam ac. Pulvinar proin gravida hendrerit lectus. Nullam vehicula ipsum a arcu cursus vitae congue mauris rhoncus. Amet massa vitae tortor condimentum lacinia quis vel eros.
                    </h3>
                    <p>Lorem ipsum:</p> 
                    <h3>
                        Lorem ipsum dolor sit amet consectetur adipiscing elit. Elementum curabitur vitae nunc sed velit dignissim sodales. Lectus quam id leo in vitae turpis. Urna cursus eget nunc scelerisque viverra mauris. Volutpat lacus laoreet non curabitur gravida arcu ac tortor. Enim facilisis gravida neque convallis a cras semper. Tristique nulla aliquet enim tortor. Malesuada proin libero nunc consequat. In pellentesque massa placerat duis ultricies lacus sed turpis tincidunt. Faucibus ornare suspendisse sed nisi. Amet risus nullam eget felis eget. Morbi tristique senectus et netus et malesuada fames ac. Enim praesent elementum facilisis leo vel fringilla est. Lectus vestibulum mattis ullamcorper velit sed ullamcorper morbi tincidunt. Pharetra massa massa ultricies mi quis hendrerit dolor magna. At erat pellentesque adipiscing commodo elit at. Pharetra diam sit amet nisl suscipit.
                    </h3> 
                    <p>Lorem ipsum:</p>
                    <h3>
                        Blandit turpis cursus in hac habitasse platea dictumst quisque. Eget gravida cum sociis natoque penatibus. Fames ac turpis egestas maecenas pharetra convallis posuere morbi. At imperdiet dui accumsan sit amet nulla facilisi morbi. Gravida quis blandit turpis cursus in. In tellus integer feugiat scelerisque varius morbi enim. Consectetur adipiscing elit pellentesque habitant morbi tristique senectus et. Imperdiet proin fermentum leo vel orci porta non. Urna cursus eget nunc scelerisque viverra mauris in. Ornare aenean euismod elementum nisi quis eleifend quam adipiscing vitae. Turpis massa tincidunt dui ut ornare lectus sit. Suspendisse in est ante in nibh mauris. Est ultricies integer quis auctor elit. Lacus vel facilisis volutpat est velit egestas dui id ornare. Cras pulvinar mattis nunc sed blandit libero volutpat sed. Arcu non odio euismod lacinia at quis risus sed vulputate.
                    </h3>  
                    <p>Lorem ipsum:</p> 
                    <h3> 
                        Suspendisse faucibus interdum posuere lorem. Ut lectus arcu bibendum at varius vel pharetra. Consectetur adipiscing elit ut aliquam purus sit. Cursus metus aliquam eleifend mi. Semper auctor neque vitae tempus quam. Pulvinar elementum integer enim neque volutpat. Faucibus a pellentesque sit amet porttitor. A iaculis at erat pellentesque adipiscing commodo elit. Suscipit tellus mauris a diam maecenas sed. Tristique senectus et netus et malesuada. Nunc aliquet bibendum enim facilisis gravida neque convallis. Volutpat est velit egestas dui id. Ac odio tempor orci dapibus ultrices in iaculis nunc sed. Tincidunt ornare massa eget egestas purus. Et sollicitudin ac orci phasellus egestas tellus rutrum. Ligula ullamcorper malesuada proin libero nunc consequat. Pellentesque eu tincidunt tortor aliquam nulla facilisi. Faucibus nisl tincidunt eget nullam non nisi est sit.
                    </h3>     
            </div>
            
            </div>
        </div>
</section>  
@endsection