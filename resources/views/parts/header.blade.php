<header>
    <div class="container">
        <div id="hamburger">
            <span></span>
        </div>

        {!! svgIcon("logo/logo-black-red.svg", ['class' => ['logo']]) !!}

        <div class="nav-container">

            <div class="searchbar">
                {!! svgIcon("icon/icon-search.svg", ['class' => ['search-icon']]) !!}
                <input type="text" placeholder="{{__("searchbar.placeholder")}}">
            </div>

            <ul class="nav">
                <li><a href="#">About</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">{{app()->currentLocale() === "sk" ? "EN" : "SK"}}</a></li>
            </ul>

            <div class="socials-container">
                @include("parts.socials")
            </div>
        </div>

        <div class="icons-container">
            <div class="icon-container">
                <a href="#">{!! svgIcon("icon/icon-search.svg", ['class' => ['search-icon']]) !!}</a>
            </div>
            <div class="icon-container">
                <a href="#">{!! svgIcon("icon/icon-cart.svg", ['class' => ['cart-icon']]) !!}</a>
            </div>
            <div class="icon-container">
                <a href="#">{!! svgIcon("icon/icon-profile.svg", ['class' => ['profile-icon']]) !!}</a>
            </div>
            <div class="icon-container">
                <a href="#">{{app()->currentLocale() === "sk" ? "EN" : "SK"}}</a>
            </div>
        </div>
    </div>
</header>
