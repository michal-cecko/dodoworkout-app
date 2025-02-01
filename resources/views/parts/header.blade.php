<header id="header" class="h-[var(--header-height)] relative z-[100]">
    <div class="px-10 flex items-center h-full gap-[95px] max-lg:justify-between max-lg:gap-0">
        <label class="hidden max-lg:block relative cursor-pointer" id="hamburger">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <input id="menu-toggle" type="checkbox" class="invisible scale-0 absolute" />
        </label>

        <a href="/" class="logo-container">
          {!! svgIcon("logo/logo-black-red.svg", ['class' => ['h-[46px] w-[110px] max-lg:h-[34px] max-lg:w-[81px]']]) !!}
        </a>

        <nav class="max-lg:hidden">
          <ul class="uppercase flex gap-12">
            <li><a class="hover:text-primary" href="#">About</a></li>
            <li><a class="hover:text-primary" href="/blog">Blog</a></li>
            <li><a class="hover:text-primary" href="#">Trainings</a></li>
            <li><a class="hover:text-primary" href="/workshops">WoRKSHOPS</a></li>
            <li><a class="hover:text-primary" href="#">shop</a></li>
            <li><a class="hover:text-primary" href="#">Contact</a></li>
          </ul>
        </nav>

        <div class="icons-container flex items-center gap-6 max-lg:gap-3 ml-auto text-[var(--icons-color)] max-lg:ml-0">
            <div class="icon-container max-lg:hidden">
                <a href="#">{!! svgIcon("icon/icon-search.svg", ['class' => ['search-icon']]) !!}</a>
            </div>
            <div class="icon-container" data-cart-items="5">
                <a href="#">{!! svgIcon("icon/icon-cart.svg", ['class' => ['cart-icon']]) !!}</a>
            </div>
            <div class="icon-container">
                <a href="#">{!! svgIcon("icon/icon-profile.svg", ['class' => ['profile-icon']]) !!}</a>
            </div>
            <div class="icon-container max-lg:hidden">
                <a href="#">{{app()->currentLocale() === "sk" ? "EN" : "SK"}}</a>
            </div>
        </div>
    </div>
</header>

<!-- Mobilne menu ktore sa ukaze ak je input:checkbox s id #menu-toggle checked, smart 😎 -->
<aside id="mobile-menu" class="fixed flex-col hidden max-lg:flex bg-[#DBDBDB] inset-0 z-[99] translate-x-[-100%] transition-all duration-300 ease-in-out pt-[var(--header-height)] px-6 pb-16">
  <div class="mt-2 rounded-full overflow-hidden flex pl-5 h-12 bg-white items-center focus-within:ring-2 focus-within:ring-primary mb-12">
    {!! svgIcon("icon/icon-search.svg", ['class' => ['']]) !!}

    <input type="search" class="w-full bg-tranparent border-none outline-none pl-4" placeholder="Vyhľadať" />
  </div>

  <ul class="flex flex-col uppercase text-3xl font-black hfont px-2">
    <li><a class="py-4 block" href="#">About</a></li>
    <li><a class="py-4 block" href="#">shop</a></li>
    <li><a class="py-4 block" href="/workshops">WoRKSHOPS</a></li>
    <li><a class="py-4 block" href="#">Trainings</a></li>
    <li><a class="py-4 block" href="/blog">Blog</a></li>
    <li><a class="py-4 block" href="#">Contact</a></li>
    <li><a class="py-4 block text-primary" href="#">EN</a></li>
  </ul>

  <div class="mt-auto flex gap px-4 justify-between items-center text-[#838383]">
    <a href="#">{!! svgIcon("icon/socials/instagram.svg", ['class' => ['w-9 h-9']]) !!}</a>
    <a href="#">{!! svgIcon("icon/socials/facebook.svg", ['class' => ['w-9 h-9']]) !!}</a>
    <a href="#">{!! svgIcon("icon/socials/linkedin.svg", ['class' => ['w-9 h-9']]) !!}</a>
    <a href="#">{!! svgIcon("icon/socials/youtube.svg", ['class' => ['w-9 h-9']]) !!}</a>
  </div>

  {!! svgIcon("svg/progress-small.svg", ['class' => ['text-white absolute z-[-1] bottom-[25%] left-0 w-full']]) !!}
</aside>
