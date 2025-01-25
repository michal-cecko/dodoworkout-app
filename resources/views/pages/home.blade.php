@extends('layouts.web')

@section('body')

<section id="hp_hero" class="relative px-14 mb-14 -mt-[var(--header-height)] pt-[var(--header-height)] max-lg:px-0" style="min-height: calc(100dvh - var(--header-height));">
  <div class="container-wrapper max-lg:mt-16 max-lg:!max-w-full">
    <div id="hero-swiper" class="relative overflow-hidden max-lg:px-[var(--container-padding)]">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <div class="flex items-center gap-12 relative max-lg:flex-col">
            <div class="w-1/2 flex flex-col gap-20 max-lg:w-full">
              <div>
                <h2 class="text-5xl uppercase max-w-[586px] max-lg:max-w-full mb-11 hfont max-lg:text-3xl">From the <b>World's Stage</b> to Your <b class="text-primary">Training Plan</b></h2>
                <div class="flex ml-2">
                  <a class="btn" data-variant="primary" href="#">My offer</a>
                  <a class="btn" href="#">About me</a>
                </div>
              </div>

              <!-- Toto je image ktory sa zobrazuje v slideri na uzsich obrazovkach --> 
              <div class="hidden relative max-lg:block w-full" style="translate: calc(-1 * var(--container-padding));">
                <img src="image/hp-hero-placeholder.jpg" class="w-full h-full object-cover rounded-r-3xl" alt="Dominik klimek performing one arm handstand.">

                <div class="hidden bg-primary absolute top-1/2 right-0 w-[343px] aspect-square -z-10 max-lg:block" style="translate: calc(var(--container-padding) * 2 + 60px) -50%;"></div>
              </div>  
              
              <div>
                <p class="text-textSecondary text-xl mb-5 pr-20 max-lg:pr-8">As the 2022 World Calisthenics Champion, I bring elite skills in strength and freestyle.
                  Through coaching, eBooks, and seminars, I help athletes push limits and achieve their goals.
                </p>
                <div class="opacity-75 flex items-center gap-6">
                  <a href="#">{!! svgIcon("icon/socials/instagram.svg") !!}</a>
                  <a href="#">{!! svgIcon("icon/socials/facebook.svg") !!}</a>
                  <a href="#">{!! svgIcon("icon/socials/linkedin.svg") !!}</a>
                  <a href="#">{!! svgIcon("icon/socials/youtube.svg") !!}</a>
                  <a href="#">{!! svgIcon("icon/socials/tiktok.svg") !!}</a>
                </div>
              </div>
            </div>

            <!-- Toto je image ktory sa zobrazuje v slideri na desktope --> 
            <div class="w-1/2 shrink-0 max-lg:hidden">
              <img src="image/hp-hero-placeholder.jpg" class="w-full" alt="Dominik klimek performing one arm handstand.">
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="flex items-center gap-12 relative max-lg:flex-col">
            <div class="w-1/2 flex flex-col gap-20 max-lg:w-full">
              <div>
                <h2 class="text-5xl uppercase max-w-[586px] max-lg:max-w-full mb-11 hfont max-lg:text-3xl">From the <b>World's Stage</b> to Your <b class="text-primary">Training Plan</b></h2>
                <div class="flex ml-2">
                  <a class="btn" data-variant="primary" href="#">My offer</a>
                  <a class="btn" href="#">About me</a>
                </div>
              </div>

              <!-- Toto je image ktory sa zobrazuje v slideri na uzsich obrazovkach --> 
              <div class="hidden relative max-lg:block w-full" style="translate: calc(-1 * var(--container-padding));">
                <img src="image/hp-hero-placeholder.jpg" class="w-full h-full object-cover rounded-r-3xl" alt="Dominik klimek performing one arm handstand.">

                <div class="hidden bg-primary absolute top-1/2 right-0 w-[343px] aspect-square -z-10 max-lg:block" style="translate: calc(var(--container-padding) * 2 + 60px) -50%;"></div>
              </div>  
              
              <div>
                <p class="text-textSecondary text-xl mb-5 pr-20 max-lg:pr-8">As the 2022 World Calisthenics Champion, I bring elite skills in strength and freestyle.
                  Through coaching, eBooks, and seminars, I help athletes push limits and achieve their goals.
                </p>
                <div class="opacity-75 flex items-center gap-6">
                  <a href="#">{!! svgIcon("icon/socials/instagram.svg") !!}</a>
                  <a href="#">{!! svgIcon("icon/socials/facebook.svg") !!}</a>
                  <a href="#">{!! svgIcon("icon/socials/linkedin.svg") !!}</a>
                  <a href="#">{!! svgIcon("icon/socials/youtube.svg") !!}</a>
                  <a href="#">{!! svgIcon("icon/socials/tiktok.svg") !!}</a>
                </div>
              </div>
            </div>

            <!-- Toto je image ktory sa zobrazuje v slideri na desktope --> 
            <div class="w-1/2 shrink-0 max-lg:hidden">
              <img src="image/hp-hero-placeholder.jpg" class="w-full" alt="Dominik klimek performing one arm handstand.">
            </div>
          </div>
        </div>
      </div>
  
      <div class="absolute bg-primary text-white left-[50%] bottom-[60px] translate-x-[-50%] z-10 flex rounded-xl max-lg:top-[68%] max-lg:translate-y-[-50%] max-lg:bottom-auto">
        <button class="pl-4 py-3" id="hero-swiper-prev">{!! svgIcon("icon/icon-arrow.svg") !!}</button>
        <div class="flex items-center gap-1 h-12 px-4">
          <span id="hero-swiper-current-page"></span>
          /
          <span id="hero-swiper-total-pages"></span>
        </div>
        <button class="pr-4 py-3" id="hero-swiper-next">{!! svgIcon("icon/icon-arrow.svg", ['class' => ['rotate-180']]) !!}</button>
      </div>
  
      <!-- Toto je ten mesh svg ktory je v pozadi na desktope --> 
      {!! svgIcon("svg/dots-mesh.svg", ['class' => ['text-[#D9D9D9] max-lg:hidden absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%]']]) !!}
    </div>
  
  </div>
  <div class="bg-primary absolute top-0 right-0 w-[463px] aspect-square -z-10 max-lg:hidden"></div>
  {!! svgIcon("svg/striped-circle.svg", ['class' => ['hidden max-lg:block text-[#FFC1C1] absolute z-[-1] right-0 top-[10%]']]) !!}

  <script type="module" defer>
    import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs'

    const swiper = new Swiper('#hero-swiper', {
      slidesPerView: 1,
      loop: true,
      spaceBetween: 60,
      navigation: {
        nextEl: '#hero-swiper-next',
        prevEl: '#hero-swiper-prev'
      },
      autoplay: {
        delay: 5000
      },
      on: {
        init: function () {
          document.getElementById('hero-swiper-total-pages').textContent =
            this.slides.length
        },
        slideChange: function () {
          document.getElementById('hero-swiper-current-page').textContent =
            this.activeIndex + 1
        }
      }
    })
  </script>
</section>

<section class="card-holder gray py-20 relative">
  <div class="container-wrapper mb-12">
    <h4 class="text-primary font-semibold mb-7 max-lg:mb-6">WORKSHOPS & CERTIFICATIONS</h4>
    <div class="flex gap-4 max-lg:flex-col">
      <h2 class="text-3xl font-bold uppercase max-w-[500px] hfont max-lg:text-3xl">Wanna become 
      a better coach?</h2>
  
      <div class="flex gap-4 ml-auto items-center text-[#B2B2B2] justify-between max-lg:ml-0">
        <button id="workshop-swiper-prev" class="border-2 border-[#B2B2B2] rounded-lg h-12 w-14 grid place-items-center">
        {!! svgIcon("icon/icon-arrow.svg") !!}
        </button>
        <button id="workshop-swiper-next" class="border-2 border-[#B2B2B2] rounded-lg h-12 w-14 grid place-items-center">
        {!! svgIcon("icon/icon-arrow.svg", ['class' => ['rotate-180']]) !!}
        </button>
      </div>
    </div>
  </div>

  <div class="flex gap-[141px] max-lg:flex-col-reverse max-lg:gap-12">
    <div class="max-lg:mx-auto" style="padding-left: max(calc((100vw - var(--max-container-width)) / 2), var(--container-padding));">
      <a href="#" class="btn self-start whitespace-nowrap" data-variant="primary" >
      view all
      </a>
    </div>  

    <div id="workshops-swiper" class="overflow-hidden w-full">
      <div class="swiper-wrapper">
        <div class="card swiper-slide">
          <div class="image-container">
            <img class="w-full h-full object-cover" src="https://loremflickr.com/455/219" alt="Dominik Klimek performing one arm handstand.">
            <div class="date-badge">
              <span class="month">NOV</span>
              <span>30</span>
            </div>
          </div>

          <h3 class="title">Become a WSWCF certified calisthenics coach</h3>

          <div class="info-container">
            <div class="info-item">
              {!! svgIcon("icon/icon-user_group.svg", ['class' => ['text-primary mx-auto']]) !!}
              <span>5 places left!</span>
            </div>

            <div class="info-item">
              {!! svgIcon("icon/icon-map_marker.svg", ['class' => ['text-primary mx-auto']]) !!}
              <span>Online meeting</span>
            </div>

            <div class="info-item">
              {!! svgIcon("icon/icon-hourglass.svg", ['class' => ['text-primary mx-auto']]) !!}
              <span>2 days</span>
            </div>
          </div>

          <p class="description">
            Join the World Association's Calisthenics Coach Certification Program.
            Enhance your skills, gain recognition, and advance your coaching career!
          </p>

          <div class="price-cta-container">
            <span class="price">999 €</span>
            <a href="#" class="cta-link text-primary">Register now</a>
          </div>
        </div>

        <div class="card swiper-slide">
          <div class="image-container">
            <img class="w-full h-full object-cover" src="https://loremflickr.com/455/219" alt="Dominik Klimek performing one arm handstand.">
            <div class="date-badge">
              <span class="month">NOV</span>
              <span>30</span>
            </div>
          </div>

          <h3 class="title">Become a WSWCF certified calisthenics coach</h3>

          <div class="info-container">
            <div class="info-item">
              {!! svgIcon("icon/icon-user_group.svg", ['class' => ['text-primary mx-auto']]) !!}
              <span>5 places left!</span>
            </div>

            <div class="info-item">
              {!! svgIcon("icon/icon-map_marker.svg", ['class' => ['text-primary mx-auto']]) !!}
              <span>Online meeting</span>
            </div>

            <div class="info-item">
              {!! svgIcon("icon/icon-hourglass.svg", ['class' => ['text-primary mx-auto']]) !!}
              <span>2 days</span>
            </div>
          </div>

          <p class="description">
            Join the World Association's Calisthenics Coach Certification Program.
            Enhance your skills, gain recognition, and advance your coaching career!
          </p>

          <div class="price-cta-container">
            <span class="price">999 €</span>
            <a href="#" class="cta-link text-primary">Register now</a>
          </div>
        </div>

        <div class="card swiper-slide">
          <div class="image-container">
            <img class="w-full h-full object-cover" src="https://loremflickr.com/455/219" alt="Dominik Klimek performing one arm handstand.">
            <div class="date-badge">
              <span class="month">NOV</span>
              <span>30</span>
            </div>
          </div>

          <h3 class="title">Become a WSWCF certified calisthenics coach</h3>

          <div class="info-container">
            <div class="info-item">
              {!! svgIcon("icon/icon-user_group.svg", ['class' => ['text-primary mx-auto']]) !!}
              <span>5 places left!</span>
            </div>

            <div class="info-item">
              {!! svgIcon("icon/icon-map_marker.svg", ['class' => ['text-primary mx-auto']]) !!}
              <span>Online meeting</span>
            </div>

            <div class="info-item">
              {!! svgIcon("icon/icon-hourglass.svg", ['class' => ['text-primary mx-auto']]) !!}
              <span>2 days</span>
            </div>
          </div>

          <p class="description">
            Join the World Association's Calisthenics Coach Certification Program.
            Enhance your skills, gain recognition, and advance your coaching career!
          </p>

          <div class="price-cta-container">
            <span class="price">999 €</span>
            <a href="#" class="cta-link text-primary">Register now</a>
          </div>
        </div>

        <div class="card swiper-slide">
          <div class="image-container">
            <img class="w-full h-full object-cover" src="https://loremflickr.com/455/219" alt="Dominik Klimek performing one arm handstand.">
            <div class="date-badge">
              <span class="month">NOV</span>
              <span>30</span>
            </div>
          </div>

          <h3 class="title">Become a WSWCF certified calisthenics coach</h3>

          <div class="info-container">
            <div class="info-item">
              {!! svgIcon("icon/icon-user_group.svg", ['class' => ['text-primary mx-auto']]) !!}
              <span>5 places left!</span>
            </div>

            <div class="info-item">
              {!! svgIcon("icon/icon-map_marker.svg", ['class' => ['text-primary mx-auto']]) !!}
              <span>Online meeting</span>
            </div>

            <div class="info-item">
              {!! svgIcon("icon/icon-hourglass.svg", ['class' => ['text-primary mx-auto']]) !!}
              <span>2 days</span>
            </div>
          </div>

          <p class="description">
            Join the World Association's Calisthenics Coach Certification Program.
            Enhance your skills, gain recognition, and advance your coaching career!
          </p>

          <div class="price-cta-container">
            <span class="price">999 €</span>
            <a href="#" class="cta-link text-primary">Register now</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  {!! svgIcon("svg/progress.svg", ['class' => ['max-lg:hidden absolute top-[50%] w-[calc(100vw * 2)]']]) !!}


  <script type="module" defer>
    import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs'

    const swiper = new Swiper('#workshops-swiper', {
      slidesPerView: 1,
      spaceBetween: 24,
      loop: true,
      navigation: {
        nextEl: '#workshop-swiper-next',
        prevEl: '#workshop-swiper-prev'
      },
      breakpoints: {
        '768': {
          slidesPerView: 2,
        },
        '1024': {
          slidesPerView: 3,
        }
      }
    })
  </script>
</section>
@endsection
