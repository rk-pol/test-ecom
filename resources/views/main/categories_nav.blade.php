<div class="main-nav-wrap flex flex-jst-c">
    <div class="main-nav flex flex-align-c flex-spc-btw">
        @foreach ($animals_arr as $key => $values)
        <div class="main-nav-title-wrap">
            <a class="main-nav-title" href="{{ URL('/') . '/' . $key }}">
                <span><?= Str::ucfirst($key)?></span>
                <div class="sub-menu-opt-wrap {{ $key }}-opt-list">
                    <ul>
                        @foreach ($values as $category => $image_path)
                        <li>
                            <a class="sub-menu-opt" href="{{ '/' . $key . '/' . $category}}">
                                <img class="sub-menu-img" src='{{ asset($image_path) }}' alt="">
                                <span class="sub-menu-title"><?= Str::ucfirst($category)?></span>
                            </a>
                        </li>  
                        @endforeach                    
                    </ul>
                </div>
            </a>
            
        </div>
        @endforeach
    </div>
    </div>
    
</div>