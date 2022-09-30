<div class="cart-modal-wrap elem-hidden">
    <div class="cart-modal-outwrap"></div>
    <div class="cart-modal flex flex-dr-col">
        <div class="cart-modal-title flex flex-abs-c">
            <span>Products: </span>
            <span id="cartAmount"></span>
        </div>
        <div class="cart-modal-main cart-scrolling flex flex-dr-col">

        </div>
        <div class="cart-modal-price flex flex-align-c flex-jst-end">
            <div>
                <div><span>Total price:</span></div>
                <div>
                    <span id="cartTotalPrice"></span>
                    <span id="price_currency"> USD</span>
                </div>
            </div> 
        </div>
        <div class="cart_buy-btn-wrap flex flex-abs-c">
            <div class="">
                <form action="{{ URL('cart/order') }}" method="GET">
                    <input class="cart_buy-btn" type="submit" name="buy" value="Buy">
                </form>
            </div>
        </div>
        <div class="cart-modal-title flex flex-abs-c"></div> 
    </div>
    
</div>

       