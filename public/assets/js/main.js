$(document).ready(function(){
    checkCart();
    detectUriForSort();
   //Add product in the cart. Change value cart icon
   //Show modal window Product was added
   $('.product-button > input').on('click', function() {
        var modalText = 'Product was added';

        //Get current product's id and price
        var id = $(this).siblings('input[name="hidden_info"]')
                                .eq(0)
                                .attr('prod_id');
        var price = $(this).parent()
                            .siblings('.product-price')
                            .eq(0)
                            .find('#price_value')
                            .text();

        //Add current prodduct id in DB
        addProductInCartDB(id)

        //Change amount and price in cart's icon
        checkCart();

        //Change statuse btn on the prod card
        $(this).addClass('product-btn-added');
        $(this).val('Added');
        $(this).prop('disabled', true);

        //Show modal window Product was added       
        showModalStatus(modalText);
    })
    
    //Change value in cart tag after click on btn Add in single page of product
    $('.product-info-single-btn > input').on('click', function() {
        var amount = $('.plus-minus').val() 
        var _token = $('meta[name="csrf-token"]').attr('content');
        var id = $(this).siblings('input[name="info_prod"]').eq(0).attr('prod_id');
        var settings = {
            type : 'POST',
            url : '/cart/store', 
            data : {
                'product_id' : id,
                'amount' : amount,
                '_token' : _token
            },
            success:function(response){
            //Fill cart with products
            checkCart();
            }, 
        }
        sendRequest(settings);        
    })
   //Open cart's modal window 
   $('.cart-icon > img').on('click', function(){
        //Clear cart
        $('.cart-modal-main').html('');

        //Stop body scrolling
        $('body').addClass('stop-scrolling');

        //Get all products from DB
        var settings = {
            type : 'GET',
            url : '/cart/all', 
            success:function(response){
                //Fill cart with products
                fillCartByProducts(response);
            }, 
        }
        sendRequest(settings);
    })       
    //Hide cart's modal by click on wrap
    $('.cart-modal-outwrap').on('click', function(){

            //Return body scrolling
            $('body').removeClass('stop-scrolling');

            //Hide cart modal
            $('.cart-modal-wrap').addClass('elem-hidden');
    })
    //Increas product's amount in cart
    $('body').on('click','.cart-plus', function(){
        //
        var _token  = $('meta[name="csrf-token"]').attr('content');
        var id = $(this).parent().siblings().find('button[class="removebtn"]').attr('data_id');
        var currVal = $(this).siblings('input').eq(0).val();   
        var newAmount = incrAmountInInput(currVal, this);
        
        if (newAmount == 20){
            return ;
        }
        //
        setTimeout(1500);
        var settings = {
            type : 'POST',
            url : '/cart/incrementAmount', 
            data : {
                'id' : id,
                'amount' : 1,
                '_token' : _token
            },
            success:function(response){
                //Rewripe price in current product
                rwCartByProduct(response[0]);

                //Fill cart with products     
                checkCart()
            }, 
        }
        sendRequest(settings);
    })
    //Disgreas product's amount in cart
    $('body').on('click','.cart-minus', function(){
        var _token  = $('meta[name="csrf-token"]').attr('content');
        var id = $(this).parent().siblings().find('button[class="removebtn"]').attr('data_id');
        var currVal = $(this).siblings('input').eq(0).val();   
        var newAmount = disgAmountInInput(currVal, this);
        
        if (newAmount == ''){
            return ;
        }

        var settings = {
            type : 'POST',
            url : '/cart/decrementAmount', 
            data : {
                'id' : id,
                'amount' : 1,
                '_token' : _token
            },
            success:function(response){
                //Rewripe price in current product
                rwCartByProduct(response[0]);

                //Fill cart with products
                checkCart();
            }, 
        }
        sendRequest(settings);
    })

    //Remove product from cart
    $('body').on('click', '.removebtn', function(){
        //Get product id
        var id = $(this).attr('data_id');
        //Remove raw from cart
        $(this).parents().eq(3).remove();
        //Change amount in cart's title and cart's icon
        //Get product's price
        var settings = {
            type : 'POST',
            url : '/cart/delete', 
            data : {
                'id' : id,
                '_token' : $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response){
                $('input[prod_id="' + id + '"]').siblings().removeClass('product-btn-added')
            }
        }  
        sendRequest(settings); 
        checkCart();  
    })
    //Admin page
    //Get brands/categories by animal
    $('#select_animal').change(function(){
        var optToAdd = ['brands', 'categories'];
        var animal_id = $(this).find(':selected').val();

        //If select_animal = Null, set other options as Null
        if (animal_id == 'null') {
            //Clear other selects
            $('#select_brand').html('');
            $('#select_category').html('');
        } else {
            //Send data to server
            var settings = {
                type : 'GET',
                url : '/admin/' + animal_id, 
                    success:function(response){
                    //Add options into Select brands/categories
                    var count = 0;
                    for (optName of optToAdd) {
                        add_options(response[count], optName);
                        count += 1;
                    }
                }, 
            }        
            sendRequest(settings);
        }   
    })
    //Hide additional menu in nav panel on admin page
    $('#admin_nav_create').mouseleave(function(){
        $('.admin-list').addClass('elem-hidden');
    })
    //Show list in admin nav panel by mouseover
    $('#admin_nav_create').mouseover(function(){
        $('.admin-list').removeClass('elem-hidden');
    })
    //Get data by selecte option in admin on main page
    $('.admin-options-btn > input').on('click', function() {
        var animal = $('#select_animal :selected').val() == undefined? 'null' : $('#select_animal :selected').val();
        var brand = $('#select_brand :selected').val() == undefined? 'null' : $('#select_brand :selected').val();
        var category = $('#select_category :selected').val() == undefined? 'null' : $('#select_category :selected').val();
        var settings = {
            type : 'POST',
            url : '/admin/all', 
            data : {
                     _token  : $('meta[name="csrf-token"]').attr('content'),
                     animal : animal,
                     brand : brand,
                     category : category  
                    },
            success:function(response){
                //Clear data in tag
                 $('.result-tbl-values').html('');
                //Add options into Select brands/categories
                if($.isEmptyObject(response) == false){
                    display_queryDB(response);
                }                
              }, 
        }
        sendRequest(settings);
    })
    //Fix nav list in admin panel after scrolling
    $(window).scroll(function(){
        ($(window).scrollTop() > 195)? $('.admin-nav-tbl').addClass('fixed'):
        $('.admin-nav-tbl').removeClass('fixed')
    });
    //Get brands/categories by provider/animal id on page Create_product
    $('.cr-prod-sl').change(function(){
        var selected_id = $(this).val();
        var id = $(this).attr('id');
        if(selected_id == 'null'){
            return;
        }
        if (id == 'cr_prod_animal') {
            var table_name = 'animals_product_types';
            var selectorId = 'cr_prod_category';
        }
        var settings = {
            type:'GET',
            url : '/admin/product/' + selected_id, 
            data : {
                'table_name' : table_name,
              },         
            success:function(response){
                for (arr of response) {
                    addOptToSelect(selectorId, arr);
                    selectorId = 'cr_prod_brand';
                }
                
              },
            }     
            sendRequest(settings);    
    })
    //Show category properties by selectec category in page Create product
    $('#cr_prod_category').change(function(){
        var category = $(this).find(':selected').text();

        //Clear all inputs
        $('.prod-parameters').find('input').val('');

        //Hid all categories
        $('.prod-param').addClass('elem-hidden');    

        switch(category) {
            case 'Toies':
                $('#toies').removeClass('elem-hidden');
                break;
            case 'Feed':
                $('#feed').removeClass('elem-hidden');
                break;
            case 'Bath':
                $('#bath').removeClass('elem-hidden');
                 break;
            case '':
                $('#bath').addClass('elem-hidden');
                 break;
        }
    })

    //Store new product in DB
    $('#store_prod_data').on('click', function(){
        var target = $(this).val();
        //Get all need data
        var category = $('select[name="product_type_id"]').val()!= 'null'?  $('select[name="product_type_id"]').val() : '';
        var category_name = $('select[name="product_type_id"]').find(':selected').text();
        var data = new FormData();
        var _token = $('meta[name="csrf-token"]').attr('content');
        
        data.append('_token', _token);
        data.append('name', $('input[name="name"]').val());
        data.append('id', $('input[name="id"]').val());
        data.append('articul', $('input[name="articul"]').val());
        data.append('brand_id', $('select[name="brand_id"]').val() != 'null' ?  $('select[name="brand_id"]').val() : '');
        data.append('animal_id', $('select[name="animal_id"]').val() != 'null' ?  $('select[name="animal_id"]').val() : '');
        data.append('product_type_id', category);
        data.append('target', target);
        data.append('product_type', category_name);
        data.append('price', $('input[name="price"]').val());
        data.append('currency', $('select[name="currency"]').val());
        data.append('discount', $('select[name="discount"]').val());
        data.append('long_description', $('textarea[name="long_description"]').val());
        data.append('short_description', $('textarea[name="short_description"]').val());
        
        if ($('input[name="is_new"]').is(':checked')) {
            data.append('is_new', '1');
        } else {
            data.append('is_new', '0');
        }
        if (target == 'Edit') {
            //Add product id
            data.append('id', $('input[name="id"]').val());
            //Add image if it was chenged
            if (typeof $('#product_img')[0].files[0] != 'undefined') {
                data.append('image_file', $('#product_img')[0].files[0]);
            }         
        } else {
            data.append('image_file', $('#product_img')[0].files[0]);
        } 
        switch(category_name) {
            case 'Toies':
                data.append('type', $('input[name="t_type"]').val());
                data.append('dimensions', $('input[name="dimension"]').val());
                data.append('material', $('input[name="material"]').val());
            break;
            case 'Feed':
                data.append('type', $('input[name="f_type"]').val());
                data.append('age', $('input[name="f_age"]').val());
                data.append('taste', $('input[name="taste"]').val());
                data.append('weight', $('input[name="weight"]').val());
            break;
            case 'Baths':
                data.append('type', $('input[name="b_type"]').val());
                data.append('age', $('input[name="b_age"]').val());
                data.append('weight', $('input[name="p_weight"]').val());
            break;
        }
        if (target == 'Edit'){
            var url = '/admin/product/update';
        } else {
            var url = '/admin/product/store';
        }
        //Prepare settings to sending
        var settings = {
            type:'POST',
            url : url, 
            data: data,
            cache:false, 
            contentType: false, 
            processData: false, 
            success:function(response){
                if($.isEmptyObject(response)){           
                    location.reload();
                } else {
                    showErrMessages(response);
                }
              },                
        }
        //Send request 
        sendRequest(settings);   
    })
    //Show/close animal's sub-menu in main_nav 
      $('.main-nav-title').on('mouseenter', function() {
        $('.sub-menu-opt-wrap').css("display",'none');
        $(this).siblings('.sub-menu-opt-wrap').css("display",'block');
    })
    $('.sub-menu-opt-wrap').on('mouseleave', function() {
        $('.sub-menu-opt-wrap').css("display",'none');
    })
    $('body').on('click', function() {
        $('.sub-menu-opt-wrap').css("display",'none');
    })
    //Swiper news
    $(document).ready(
        function () {
        var swiper = new Swiper('.swiper-news', {
                speed: 2500,
                direction: 'horizontal',
                loop: true,
	            stopOnLastSlide: false,
                autoplay: {
                    delay: 2500
                },
                nextButton: '.swiper-button-next',
                prevButton: '.swiper-button-prev',
                slidesPerView: 1,
                spaceBetween: 20,
        })
    })
    // Swiper new products
    $(document).ready(
        function () {
            var swiper = new Swiper('.swiper-products', {
                direction: 'horizontal',
                 loop: true,
                 nextButton: '.new-products-next',
                 prevButton: '.new-products-prev',
                 slidesPerView: 5,
                spaceBetween: 15,               
             });
    });
    // Swiper hit products
    $(document).ready(
        function () {
            var swiper = new Swiper('.swiper-hit-selling', {
                direction: 'horizontal',
                loop: true,
                nextButton: '.hit-sell-next',
                prevButton: '.hit-sell-prev',
                slidesPerView: 5,
                spaceBetween: 15,
             });
    });
    //Admin -> create animal (page)
    //Create new animal/product_type(category)/brand/provider
    $('.create-btn').on('click', function(){
        var data_name = $(this).attr('data_name');
        var _token = $('meta[name="csrf-token"]').attr('content');
        if(data_name == 'animals') {
            var table_name = 'animals';
            var selector = '#new_animal';
            var select_name = 'animals';
            var new_name = $(selector).val();
            var modalText = 'Animal was added';
        }
        if(data_name == 'categories') {
            var table_name = 'product_types';
            var selector = '#new_category';
            var select_name = 'categories';
            var new_name = $(selector).val();
            var modalText = 'Category was added';
        }
        if(data_name == 'brands') {
            var table_name = 'brands';
            var selector = '#new_brand';
            var select_name = 'brands';
            var new_name = $(selector).val();
            var modalText = 'Brand was added';
        }
        if(data_name == 'providers') {
            var table_name = 'providers';
            var selector = '#new_provider'; 
            var select_name = 'providers';
            var new_name = $(selector).val();
            var modalText = 'Provider was added';
        }
        //Make paths     
        if (data_name == 'animals' || data_name == 'categories') {
            var path_store = '/admin/animal/' + table_name + '/store';
            var path_rw = '/admin/animal/' + table_name + '/all';
        } else {
            var path_store = '/admin/provider/' + table_name + '/store';
            var path_rw = '/admin/provider/' + table_name + '/all';
        }        
        //
        var settings = {
            type:'POST',
            url : path_store, 
            data: {
                '_token': _token,
                'name': new_name,
                'table_name' : table_name
            },
            success:function(response){
                //If the response doesn't have errors   
                if($.isEmptyObject(response)){                   
                    if (typeof selector !== "undefined") {
                        //Clear input
                        $(selector).val('')
                        //Clear error's text
                        $(selector).siblings('div').find('span').html('');
                    }                   
                    //Rewrite select with new data
                    if (typeof select_name !== "undefined") {
                        
                        rwSelect(select_name, path_rw);
                    }        
                    //Show modal status
                    showModalStatus(modalText);
                } else {
                    //Show error
                    $(selector).siblings('div').find('span')
                            .removeClass('elem-hidden')
                            .html(response);
                }   
              },                
        }
        if (new_name) {
            sendRequest(settings);
        }
       
    })
    //Show all animals/product_types(categories)/brand/provider
    // in admin on page Create->Animals
    $('.show-btn').on('click', function(){
        var data_name = $(this).attr('data_name');
        //
        if(data_name == 'animals') {
            var table_name = 'animals';
            var table_title = 'Animals';
        }
        if(data_name == 'categories') {
            var table_name = 'product_types';
            var table_title = 'Categories';
        }
        if(data_name == 'brands') {
            var table_name = 'brands';
            var table_title = 'Brands';
        }
        if(data_name == 'providers') {        
            var table_name = 'providers';
            var table_title = 'Providers';
        }
        if (data_name == 'animals' || data_name == 'categories') {
            var url = '/admin/animal/' + table_name + '/all';
        } else {
            var url = '/admin/provider/' + table_name + '/all';
        }  
        //Show what was selected
        $('.res-title > span').text(table_title);
        //Prepare settings
        var settings = {
            type:'GET',
            url : url, 
            success:function(response){
                createTag(response, table_name);
              },  
            }      
        sendRequest(settings);
    })
    //Make product's tab active on page with single product
    $('.tab__btn').on('click', function() {
        var currTab = $(this).attr('data-btn');

        $('.tab__btn').removeClass('active');
        $(this).addClass('active');
        
        $('.content').removeClass('active');
        $("div[data-cont=" + currTab + "]").addClass('active');
    })
    // Show modal window for edding animal/category name
    $('body').on('click', '.btn-edit', function(){
        var id = $(this).attr('data_id');
        var old_name =  $(this).parent().parent().siblings().find('span').eq(1).html();

        $('input[name="mw_old_category"]').attr('value', old_name).prop('readonly', true);
        $('input[name="mw_new_category"]').attr('data_id', id);
        $('.modal-editcateg').addClass('active');
    });
    //Hide modal title
    $('#modal__overlay').on('click', function(){
        $('#modal').removeClass('active');
    })
    //Modal window confirm. Edit selected category
    $('.btn-modal-confirm').on('click', function() {
        var _type = $('.res-title > span').text();
        var new_name = $('input[name="mw_new_category"]').val();
        var id =  $('input[name="mw_new_category"]').attr('data_id');
        var _token = $('meta[name="csrf-token"]').attr('content');       
        //
        if (_type == 'Animals') { 
            var modalText = 'Animal was changed';
            var table_name = 'animals';
        } 
        if (_type == 'Category') {
            var modalText = 'Category was changed';
            var table_name = 'product_types';
        }
        if (_type == 'Providers') {
            var modalText = 'Provider type was changed';
            var table_name = 'providers';
        }
        if (_type == 'Brands') {
            var modalText = 'Brand was changed';
            var table_name = 'brands';
        }
        if (_type == 'Animals' || _type == 'Category') {
            var url = '/admin/animal/' + table_name + '/edit';
        } else {
            var url = '/admin/provider/' + table_name + '/edit';
        }  
        var settings = {
                    type : 'POST',
                    url : url,
                    data : {
                        'id' : id,
                        'name' : new_name,
                        '_token': _token
                    },
                    success:function(response){
                        //If the response dosent have errors               
                        if($.isEmptyObject(response)){
                            //
                            $('input[name="mw_new_category"]').val('');
                            //Show modal status
                             showModalStatus(modalText);
                             //Hid modal window
                             $('#modal').removeClass('active');
                             //Rewrite selects :animal / category
                             if (_type == 'Animals') {
                                var path = '/my_admin/create_animal/show/animals';
                                var name = 'animals';
                                rwSelect(name, path);
                            } else {
                                var name = 'categories';
                                var path = '/my_admin/create_animal/show/product_types';
                                rwSelect(name, path);
                            } 
                        } else {
                        }       
                      },  
               };
        sendRequest(settings);
    })
    //Delete category/animal on admin page Create->amimal
    $('body').on('click', '.btn-del', function(){
        var currElem = this
        var _type = $(this).attr('data_name');
        var id = $(this).attr('data_id');
        var table_name = $(this).attr('data_name');
        var _token = $('meta[name="csrf-token"]').attr('content');

        if (_type == 'animals') {
            var name = 'animals';
            var modalText = 'Animal was deleted';
        }  
        if (_type == 'product_types') {
            var name = 'categories';
            var modalText = 'Category was deleted';
        }
        if (_type == 'providers') {
            var name = 'providers';
            var modalText = 'Provider was deleted';
        }
        if (_type == 'brands') {
            var name = 'brands';
            var modalText = 'Brand was deleted';
        }
        if (_type == 'animals' || _type == 'product_types') {
            var url = '/admin/animal/' + table_name + '/delete';
        } else {
            var url = '/admin/provider/' + table_name + '/delete';
        } 
        var path = '/admin/animal/' + table_name + '/all';
        var settings = {
            type : 'POST',
            url :  url,
            data : {
                'table_name' : table_name,
                'id' : id,
                '_token': _token
            },
            success:function(response){
                //If the response dosent have errors               
                if($.isEmptyObject(response)){
                    //Delete current raw
                    $(currElem).parents().eq(2).remove();
                     //Show modal status
                     showModalStatus(modalText);
                    //Hid modal window
                    $('#modal').removeClass('active');
                    //Rewrite selects :animal / category
                    rwSelect(name, path);  
                } else {
                }       
            },  
        };
        sendRequest(settings);
    })
    //
    $('body').on('click','.tbl-btn-del', function(){
        var currRaw = this;
        var id_product = $(this).attr('id_prod');
        var _token = $('meta[name="csrf-token"]').attr('content');
        var modalText = 'Product was deleted';

        var settings = {
            type:'POST',
            url : '/admin/product/delete', 
            data: {
                'id' : id_product,
                '_token' : _token
            },
            success:function(response){
                 //If the response doesn't have errors               
                 if($.isEmptyObject(response)){
                     //Show modal status
                     showModalStatus(modalText);
                    //Delete current raw
                    $(currRaw).parents().eq(1).remove();
                }
            },                
        }
        sendRequest(settings)
    })
    //Make dependecies on admin page Create->create
    $('.make-depen-btn').on('click', function(){
        var data_dep = $(this).attr('data_dep');
        var _token = $('meta[name="csrf-token"]').attr('content');
        var modalText = 'Dependecies was made';
        //
        if(data_dep == 'an-cat') {
            var first_select = '#cr-animal-sl';
            var second_select = '#cr-category-sl';
            var first_name = 'animal_id';
            var second_name = 'product_type_id';
            //animal_id
            var first_id = $('#cr-animal-sl').find(':selected').val();
            //product_type_id
            var second_id = $('#cr-category-sl').find(':selected').val();
            //
            var category_name = $('#cr-animal-sl').find(':selected').text();
        }
        if(data_dep == 'pr-br') {
            var first_select = '#cr-provider-sl';
            var second_select = '#cr-brand-sl';
            var first_name = 'provider_id';
            var second_name = 'brand_id';
            //id_providers
            var first_id = $('#cr-provider-sl').find(':selected').val();
            //brand_id
            var second_id = $('#cr-brand-sl').find(':selected').val();
        }
        if(data_dep == 'an-br') {
            var first_select = '#cr-animal-sl';
            var second_select = '#cr-brand-sl-2';
            var first_name = 'animal_id';
            var second_name = 'brand_id';
            //animal_id
            var first_id = $('#cr-animal-sl').find(':selected').val();
            //brand_id
            var second_id = $('#cr-brand-sl-2').find(':selected').val();
        }
        //Preaper settings
        if (data_dep == 'an-cat') {
            var data = new FormData();
            var _token = $('meta[name="csrf-token"]').attr('content');
            data.append('_token', _token);
            data.append('image_file', $('input[name="image_file"]')[0].files[0]);
            data.append('first_name', first_name);
            data.append('second_name', second_name);
            data.append('first_id', first_id);
            data.append('second_id', second_id);
            data.append('category', category_name);
            //
            var settings = {
                type:'POST',
                url : '/admin/animal/' + data_dep + '-dep', 
                data: data,
                cache:false, 
                contentType: false, 
                processData: false, 
                success:function(response){
                    // console.log(response)
                    //Set selects default value
                    $(first_select).find('option[value="null"]').prop('selected','selected')
                    $(second_select).find('option[value="null"]').prop('selected','selected')
                     //If the response doesn't have errors               
                     if($.isEmptyObject(response)){
                        //Show modal status
                        
                        showModalStatus(modalText);
                    }
                },                
            }
        } else {
            var settings = {
                type : 'POST',
                url : '/admin/provider/' + data_dep + '-dep', 
                data : {
                    'first_name' : first_name,
                    'second_name' : second_name,
                    'first_id' : first_id,
                    'second_id' : second_id,
                    '_token': _token
                },
                success:function(response){   
                    //Set selects default value
                    $(first_select).find('option[value="null"]').prop('selected','selected')
                    $(second_select).find('option[value="null"]').prop('selected','selected') 
                     //If the response doesn't have errors               
                    if($.isEmptyObject(response)){
                        //Show modal status
                        // console.log(response)
                        showModalStatus(modalText);
                    }
                },  
            }
        }      
        sendRequest(settings);
    })
    //Cart
   //Increase count of product's amount
   $('.plus-minus-count-plus').on('click', function(){

        var currVal = $(this).siblings('input').eq(0).val();   
        var newAmount = incrAmountInInput(currVal, this);
        if (newAmount == '') {
            return ;
        }
        var basePrice = $('input[name="base_price"]').val();
        var sum = Number(newAmount) * Number(basePrice);
        var newPrice = preparePrice(sum);
        $('span[id="prod_price"]').text(newPrice);     
    })
    //Put selected product's image instead placeholder 
     $('#product_img').on('change', function() {
        var href = URL.createObjectURL(this.files[0])

        $('.img-placeholder').attr('src', href);
    })
    //Disgreas count of product's amount
    $('.plus-minus-count-minus').on('click', function(){
        var currVal = $(this).siblings('input').eq(0).val(); 
        var newVal = disgAmountInInput(currVal, this);

        if (newVal == ''){
            return ;
        }
        //Cahnge price -
        var basePrice = $('input[name="base_price"]').val();
        var currPrice = $('span[id="prod_price"]').text(); 
        var totalPrice = Number(currPrice) - basePrice;

        newTotalPrice = preparePrice(totalPrice);
        
        $('span[id="prod_price"]').text(newTotalPrice); 
    })
    //Check value of product's amount
    $( ".plus-minus-count > input" ).keyup(function() {
        var currVal = $('.plus-minus-count > input').val();
        if ($.isNumeric(currVal) != true) {
            $('.plus-minus-count > input').css('color', 'red');
            $('.product-info-single-btn > input').prop( "disabled", true );
        } else {
            if(Number.isInteger(Number(currVal)) == false) {
                $('.plus-minus-count > input').css('color', 'red');
                $('.product-info-single-btn > input').prop( "disabled", true );
            } else { 
                if (currVal == '0') {
                    $(this).val('1');
                } else if (Number(currVal) >= '20') {
                    $(this).val(20)
                    var basePrice = $('input[name="base_price').val();
                    var totalPrice = (20 * Number(basePrice)).toFixed(2);                    
                } else {
                    var basePrice = $('input[name="base_price').val();
                    var totalPrice = (Number(currVal) * Number(basePrice)).toFixed(2);
                }
                newTotalPrice = preparePrice(totalPrice);
                $('span[id="prod_price"]').text(newTotalPrice);

                $('.plus-minus-count > input').css('color', 'black');
                $('.product-info-single-btn > input').prop( "disabled", false );             
            }
        }
    });
    //Get page product info
    $("select[name='sortBy']").change(function(e){
        $(this).parent().submit();
    })
    // //Check value of product's amount
    $('body').on('keyup', ".plus-minus-cart", function() {
        var currVal = $(this).val();
        var _token  = $('meta[name="csrf-token"]').attr('content');
        var id = $(this).parent().siblings().find('button[class="removebtn"]').attr('data_id');

        if ($.isNumeric(currVal) != true) {
            $(this).val('1');
        } else {
            if(Number.isInteger(Number(currVal)) == false) {
                $(this).val('1');
            } else { 
                if (currVal == '0') {
                    $(this).val('1');
                } else if (Number(currVal) >= '20') {
                    $(this).val(20)

                } else {
                
                }       
            }
        }
        amount = $(this).val();

        setTimeout(function(amount) {
            var settings = {
                type : 'POST',
                url : '/cart/update', 
                data : {
                    'id' : id,
                    'amount' : amount,
                    '_token' : _token
                },
                success:function(response){
                    //Rewripe price in current product
                    rwCartByProduct(response[0]);

                    //Fill cart with products
                    checkCart();
                }, 
            }
            sendRequest(settings);
        }, 800, amount)
    });
})
    
//Create table for showing data
function createTag(response, table_name) {
    var count_id = 1;
    var html_tag = '';
    //Cleare previous data
    $('.res-to-clear').html('');
    //Create tage and filling date
    for (key in response) {
        html_tag += '<div class="cr-animal-res-wrap flex flex-spc-btw">';
        html_tag += '<div class="cr-animal-res-data-wrap">';
        html_tag += '<div class="cr-animal-res-data flex flex-spc-btw">';
        html_tag += '<span>' + count_id + '</span>' + '<span>' + response[key].name + '</span>';
        html_tag += '</div></div>';
        html_tag += '<div class="res-btn">';
        html_tag += '<div class="flex flex-spc-btw">';
        html_tag += '<input class="btn-edit" data_name="' + table_name + '"type="button" value="Edit" data_id="' + response[key].id + '">';
        html_tag += '<input class="btn-del" data_name="' + table_name + '"type="button" value="Delete" data_id="' + response[key].id + '">';
        html_tag += '</div></div>';
        html_tag += '</div>';
        count_id += 1;
    }
    //
    $('.res-to-clear').append(html_tag);
}
//Send request to server
function sendRequest(settings) {
    $.ajax(settings)
        .done(function(response) {
            console.log('Success');
        })
        .fail(function(response) {
            console.log('Fail');
            // console.log(response);
        })
}
//Add options to select
function add_options(response, name) {
    //
    var html_text = '';
    //Clear existing select's options
    if($("select[name='" + name + "'").find('option').length > 0){
        $("select[name='" + name + "'").html('');
    }
    //Add blank
    html_text += '<option value="null"></option>';
    //Loop response
    for (val of response) {
        html_text += '<option value="' + val.id + '">' + 
                     (val.value !== undefined ? val.value: val.name) + '</option>';
    };
    //Add new options to select
    $("select[name='" + name + "'").append(html_text); 
}
//Create html elem animal and fill with data from DB
function display_animals(response) {
    var index = 0;

    //Delete all data in .admin-field
    $(".admin-field div").remove();

    for (animal of response) {
        //Get name of img
        arr_match = [];
        arr_match = animal.img_path.match(/([a-zA-Z0-9_\s]*\.[a-zA-Z]+)/)
        if (arr_match != null) {
            img_name = arr_match[0];
        } else {
            img_name = 'placeholder.jpg';
        }
        //imgPath and animalPath were added  to app.blade.php in body section
        // csrf = $("<input>", {name:"_token", value: $("meta[name='csrf-token']").attr('content')}).hide();
        firs_div = $("<div>", {id: "foo", "class": "img-wrap flex flex-dr-col flex-align-c"});
        div_species_name = $("<span>", {class:'species-title'}).html(animal.species_name);
        tag_img = '<img src=' + imgPath + '/' + animal.category + '/' + img_name  + ' class=img-placeholder></img>';
        second_div = $("<div>", {"class": "flex flex-spc-ard img-wrap-btns"});
        form_start = $("<form>", {action: "{{ URL()->current() }}"});
        tag_form_edit = $("<form>", {action: animalPath + '/edit' , class: 'img-btn-edit-wrap', method: 'GET'});
        tag_div_delete = $("<div>", {action: animalPath + '/delete', class: 'img-btn-del-wrap'});
        input_hidden = $("<input>", {type: "hidden", class: 'img-btn-edit-animal', name: "animal_id", value: '' + animal.id});
        input_edit = $("<input>", {type: "submit", class: 'img-btn-edit-animal', animal_id: '' + animal.id, value:  "Edit"});
        input_del = $("<button>", {type: "button", class: 'img-btn-del-animal', animal_id: '' + animal.id}).html('Delete');
        tag_hr = $("<hr>", {"class": "hr-adm"});
        //
        $(".admin-field").append(firs_div);
        $(".img-wrap").eq(index).append(div_species_name);
        $(".img-wrap").eq(index).append(decodeEntities(tag_img));
        
        $(".img-wrap").eq(index).append(second_div);
        $(".img-wrap-btns").eq(index).append(tag_form_edit);
        // $(".img-btn-edit-wrap").append(csrf);
        $(".img-btn-edit-wrap").eq(index).append(input_hidden);
        $(".img-btn-edit-wrap").eq(index).append(input_edit);
        $(".img-wrap-btns").eq(index).append(tag_div_delete);
        $(".img-btn-del-wrap").eq(index).append(input_del);
        $(".img-wrap").eq(index).append(tag_hr);
        $('.admin-field').eq(index).removeClass('admin-field-display')
        index += 1;
    }   
}
//Set current option selected in sort tag on page
function detectUriForSort() {
    var url  = window.location.href;
    var optArr = url.match(/(?<==)[a-z_]*(ASC|DESC)$/);
    if (optArr !== null) {
        var findedOpt = optArr[0];
        $('select[name="sortBy"] > option[value="' +  findedOpt + '"]').prop('selected', true);
    }
}
//Display information from DB on main page in my admin
function display_queryDB(response) {

    //Create new tables with data
    var html_text = '';
    for (var animal_key in response) {    
        html_text += '<div class="res-title-animal">' + capitalizeFirstLetter(animal_key) + '</div>';
        for(var type_key in response[animal_key]){
            html_text += '<div class="res-type"><span>' +  capitalizeFirstLetter(type_key) + '</span></div>';
            html_text += '<table id="res_opts">';
            html_text += '<tr><th>Brand</th><th>Product name</th><th>Price, USD</th><th>Edit/Delete</th><tr>'
            for(var key in response[animal_key][type_key]) {
                html_text += '<tr>';
                html_text += '<td>'+ response[animal_key][type_key][key].brand + '</td>';
                html_text += '<td id="tbl_td_w">'+ response[animal_key][type_key][key].name + '</td>';
                html_text += '<td>'+  response[animal_key][type_key][key].price + '</td>';
                html_text += '<td class="res-opts-btn flex flex-spc-btw">';
                html_text += '<form action="' + animalPath + '/product/edit/' + response[animal_key][type_key][key].id + '" method="get">';
                html_text += _token;
                html_text += '<input class="btn-edit tbl-btn-edit" type="submit" value="Edit">';
                html_text += '</form>';
                html_text += '<input class="tbl-btn-del" id_prod="' + response[animal_key][type_key][key].id + '"type="button" value="Delete"></td>';
                html_text += '</tr>';
            }
            html_text += '</table>';
        }
    }
    //Add new data
    $('.result-tbl-values').append(html_text);
}
//Make first char uppercase
function capitalizeFirstLetter(string){
    return string.charAt(0).toUpperCase() + string.slice(1);
}
//Set options in provider select
function addOptToSelect(selectorId, response) {
    var html_text = '<option value="null"></option>';
    //clear tag select
    $('#' + selectorId).html('');
    //
    for (key in response) {
        html_text += '<option value="' + response[key].id + '">' + capitalizeFirstLetter(response[key].name)+ '</option>';
    }
    //Add new list of oprions to select
    $('#' + selectorId).append(html_text);
}
//Validate data before send to server
function createValidateConstraints() {
    var constraints = {
        name: {
          presence: true,
          format: {
            pattern: /[a-zA-Z]*/,
            message: function(value, attribute, validatorOptions, attributes, globalOptions) {
              return validate.format("^%{num} is not a valid name", {
                num: value
              });
            }
          }
        },
        articul: {
            presence: true,
            length: {
              minimum: 6,
              message: "must be at least 6 characters"
            }
        },
        short_desc: {
            presence: true,
            length: {
              minimum: 15,
              maximym: 50,
              message: "must be at least 15 and maximus 50 characters"
            }
          },
        long_desc: {
            presence: true,
            length: {
              minimum: 15,
              maximym: 50,
              message: "must be at least 15 and maximus 50 characters"
            }
          }
          
      };
      return constraints;
}
//Show errors messages
function showErrMessages(response){
    //Check if there are no errors from server
    if($.isEmptyObject(response) == false){
        //Loop errors 
        for(var err_field in response){
            //
            if (err_field == 'price') {
                $('.prod-new-wrap').find('#priceErr').removeClass('elem-hidden')
                        .html(response[err_field][0])
                continue;
            }
            //Add error message near the current field
            $('.prod-new-wrap').find('[name="' + err_field + '"]').siblings('.textErr').removeClass('elem-hidden')
                            .html(response[err_field][0])

        }
    }
}
//Show the modal window with information text
function showModalStatus(text){
    //Insert the text
    $('.show-status-wrap > span').html(text);
    //Show the modal window
    $('.show-status-wrap').fadeIn()
    setTimeout(function() {
        $('.show-status-wrap').fadeOut()
    }, 1500);
}
//Rewrite select
function rwSelect(name, path) {
    //Clear old data
    $("select[name='" + name + "'").html('');
    //Get new data with animals
    var settings = {
        type : 'GET',
        url : path, 
            success:function(response){
                //Add options into Select 
                add_options(response, name);
            }
        }   
    sendRequest(settings);   
}
//CART
//
function checkCart() {
    var settings = {
        type : 'GET',
        url : 'http://' + window.location.host + '/cart/check', 
        success:function(response){
            changeIconCartValues(response[0][0]);
            disableProductsOnPage(response[1]);
        } 
    }  
    sendRequest(settings);  
}
//
function disableProductsOnPage(products) {

    for(var count in products) {  
        $('input[prod_id="' + products[count].product_id + '"]').siblings().addClass('product-btn-added');
    }
}
//Create raws into cart
function fillCartByProducts(products) {
    var html_text = '';
    var num = 0;
    var totalSum = 0;
    var currPrice = [];

    //clear cart
    $('.cart-modal-main').html('');
    
    for(var count in products) {    
        currPrice = (Number(products[count].amount) * Number(products[count].price));

        html_text += '<div class="cart-rw-prod ">';
        html_text += '<div class="flex flex-spc-btw">';
        html_text += '<div>';
        html_text += '<img class="cart-image" src="'+ products[count].image_path + '">'
        html_text += '</div>';
        html_text += '<div class="cart-string flex flex-spc-btw">';
        html_text += '<div class="cart-row-name flex flex-abs-c">';
        html_text += '<span>'+ products[count].name + '</span>';
        html_text += '</div>';
        html_text += '<div class="cart-row-desc flex flex-abs-c">';
        html_text += '<span>'+ products[count].short_description + '</span>';
        html_text += '</div>';
        html_text += '</div>';
        html_text += '<div class="cart-btns flex flex-spc-btw">';
        html_text += '<div class="plus-minus-count-cart flex flex-spc-btw flex-align-c">';
        html_text +=  '<img class="cart-minus pm_img" src="' + imgPath +'assets/img/Main/_minus.png">';
        html_text +=  '<input type="text" name="quantity" class="plus-minus-cart" value="' +  products[count].amount + '">'
        html_text +=  '<img class="cart-plus pm_img" src="' + imgPath + 'assets/img/Main/_plus.png">';
        html_text += '</div>';    
        html_text += '<div class="cart-row-price flex flex-abs-c">';
        html_text += '<span>'+ preparePrice(currPrice) + '</span>';
        html_text += '<span> USD </span>';
        html_text += '</div>';  
        html_text += '<div class="flex flex-abs-c">';
        html_text += '<button type="button" class="removebtn" data_id="' + products[count].product_id + '">Remove</button>';
        html_text += '</div>';   
        html_text += '</div>'; 
        html_text += '</div>';  
        html_text += '<hr>';  
        html_text += '</div>'; 
        
        totalSum += Number(currPrice);
        num += 1;
    }

    //Desplay modal
    $('.cart-modal-wrap').removeClass('elem-hidden');

    //Add to cart field
    $('.cart-modal-main').append(html_text);
    $('#cartAmount').text(num);
    
    //Add total sum of price 
    $('#cartTotalPrice').text(preparePrice(totalSum));
}
//
function rwCartByProduct(product) {
    var currPrice = 0;
    
    currPrice = (Number(product.amount) * Number(product.price));

    //Rewrite price
     $('.cart-modal-main ').find('button[data_id="' + product.product_id + '"]')
                            .parent()
                            .siblings('.cart-row-price')
                            .find('span')
                            .eq(0)
                            .text(preparePrice(currPrice));
    
}
//
function changeIconCartValues(cartValues) {

    if (cartValues == undefined) {
        cartValues= {
            'amount' : 0,
            'price' : '0.00'
        }
    }
    //Add new amount in cart's icon
    $('.prod-count > span').text(cartValues.amount);
    $('#cartAmount').text(cartValues.amount);

    //Add new value in cart's title 'amount of products'
    $('#cart-icon-price').text(cartValues.price);
    $('#cartTotalPrice').text(cartValues.price);
}
//Increase amount in input
function incrAmountInInput(currVal, thisObj){
    var newValue = 0;
    if ($.isNumeric(currVal) == true){ 
        //Set max amount of 1 product
        if (Number(currVal) >= '20') {
            newValue = 20;  
        } else {
            newValue = Number(currVal) + 1;
        }
        //Change value in input       
        $(thisObj).siblings('input').val(newValue);
        return newValue;
    }
    return '';
}
//Disgreas amount in input
function disgAmountInInput(currVal, thisObj){
    var newValue = 0;
    if ($.isNumeric(currVal) == true){
        if (Number(currVal) > 1) {
            //
            newValue = Number(currVal) - 1;
            //Change value in input     
            $(thisObj).siblings('input').val(newValue);

            return newValue;
        } else {
            return '';
        }
    }
    return '';
}
//Add new product id in cart in DB by uuid
function addProductInCartDB(product_id, amount = 1){
    var _token  = $('meta[name="csrf-token"]').attr('content');
    var settings = {
        type : 'POST',
        url : '/cart/store',
        data : {
            'product_id' : product_id,
            'amount' : amount,
            '_token' : _token 
        },
        success:function(response){
            // console.log(response)
          }, 
    }  
    sendRequest(settings); 
}
//Change icon catr amount of items
function changeIconCartAmount(amount, mathOper){
    var currAmount = Number($('.prod-count > span').text());
    if (mathOper == 'increment') {
        var newAmount = currAmount + amount;
    }
    if (mathOper == 'decrement') {
        var newAmount = currAmount - amount;
    }
    //Change icon's cart amount
    $('.prod-count > span').text(newAmount);
}
function preparePrice(sum) {
    totalSum = sum.toFixed(2);
    totalArr = String(totalSum).split('.');

    if (totalArr.length == 1) {
        newTotalPrice = totalArr[0] + '.00';
    } else if(totalArr[1].length == 1){
        newTotalPrice = totalArr[0] + '.' + totalArr[1] + '0';
    } else {
        newTotalPrice = totalSum;
    }
    return newTotalPrice;
}
