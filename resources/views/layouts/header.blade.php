<header> 
  <div class="header-wrap flex">
    <div class="header flex flex-jst-c">
      <div class="header-main-wrap flex flex-spc-btw">
        <div class="header-logo flex flex-abs-c">
          <a href="{{ URL('/') }}" class="header-logo-home">
            <img  class="logo-img" src="{{ asset('assets/img/main/logo.jpg') }}">
          </a>
        </div>
        <div class="flex">
          @can('admin')
            <div class="header-admin  flex flex-abs-c">
              <a href="{{ URL('/admin') }}">
              <span class="header-title">My admin</span> 
              </a>
            </div>
          @endcan
          <div class="header-login flex flex-abs-c">
            @auth('web')
              <a href="{{ route('logout') }}">
                <span class="header-title">Logout</span>
              </a>
            @endauth
            @guest
              <a href="{{ route('login') }}">
                <span class="header-title">Login</span>
              </a>             
            @endguest            
          </div>
        </div>  
      
      </div>
      
    </div>
    <div class="cart-icon-wrap flex flex-align-c ">
      <div class="cart-icon">
          <img src="{{ asset('assets/img/Main/cart_icon.png') }}">
        <div class="prod-count-wrap">
          <div class="prod-count">
            <span>0</span>
          </div>
        </div>
      </div>
      <div class="cart-icon-price flex flex-dr-col ">
          <span>Total:</span>
          <div class="cart-icon-price-value">
            <span id="cart-icon-price">0.00</span>
            <span>USD</span>
          </div>      
      </div>
    </div>
  </div>
</header>