@extends('layouts.web')

@section('body')
<section id="bootcamp">
  <div
    class="h-[512px] bg-primary"
    style="background: url('https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80') 50% / cover no-repeat;">
  </div>
  
  <div class="pb-24">
    <div class="-mt-[100px] max-w-[1027px] mx-auto">
      <div class="bg-white px-11 rounded-[30px] border border-[#EDEDED] grid grid-cols-3 mb-14">
        <div class="col-span-2 pr-11 py-11">
          <div class="flex gap-9 items-start mb-4">
            <div class="date-badge bg-[#F8F8F8] border border-[#EDEDED] shrink-0" data-variant="lg">
              <span class="month">NOV</span>
              <span>30</span>
            </div>
            <div>
              <span class="uppercase text-sm text-textSecondary mb-3">bootcamp</span>
              <h2 class="hfont text-3xl font-black">Become a WSWCF certified calisthenics coach </h2>
            </div>
          </div>
          <p class="text-sm text-textSecondary mb-10">Join the World Association's Calisthenics Coach Certification Program. Enhance your skills,
            gain recognition, and advance your coaching career!</p>
          <div class="flex gap-12">
            <div class="text-textSecondary text-lg">
              <div class="text-primary font-bold text-sm flex items-center gap-3 mb-1">
              {!! svgIcon("icon/icon-map_marker.svg") !!}
              Address
              </div>
              Online meeting
            </div>

            <div class="text-textSecondary text-lg">
              <div class="text-primary font-bold text-sm flex items-center gap-3 mb-1">
              {!! svgIcon("icon/icon-calendar.svg") !!}
              Date
              </div>
              30. november - 31. november 2024
            </div>
          </div>
        </div>

        <div class="col-span-1 flex flex-col pl-11 py-11 border-l border-dashed border-[#EDEDED]">
          <span class="sale-tag mb-5">SALE!</span>
          <h3 class="font-black text-3xl hfont"><span class="highlight">Register</span> now,<br />still 5 places left!</h3>
          
          <div class="flex mt-auto">
            <div>
              <div class="text-lg line-through text-textSecondary">999 €</div>
              <div class="text-4xl font-bold text-primary">900   €</div>
            </div>

            <button class="btn self-end ml-auto" data-variant="primary">Register
            {!! svgIcon("icon/icon-lucide_arrow.svg") !!}

            </button>
          </div>
        </div>
      </div>

      <div class="flex gap-12 items-start pl-11">
        <article class="w-full">
          <h1>Heading 1</h1>

          <p>
          Consistency is the secret weapon of <b>every successful athlete</b>. Whether you're just starting out or aiming for the next level, showing up <a href="#">every day makes</a> all the difference. In this post, we'll dive into why consistency matters and how you can cultivate it to unlock your full potential.
          </p>

          <h2>Heading 2</h2>

          <p>
          Consistency is the secret weapon of every successful athlete. Whether you're just starting out or aiming for the next level, showing up every day makes     all the difference. In this post, we'll dive into why consistency matters and how you can cultivate it to unlock your full potential.
          </p>

          <div class="image-container">
            <div class="image-container-image">
              <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="Dominik Klimek performing one arm handstand.">
            </div>

            <p class="image-container-caption">
            Dominik when talking some bullshit nobody cares about. Source: <b>I dont have a fucking clue</b>
            </p>
          </div>

          <ul>
            <li>Consistency is the secret weapon of every successful athlete.</li>
            <li>Consistency is the secret weapon of every successful athlete. Consistency is the secret weapon of every successful athlete.</li>
            <li>Consistency is the secret weapon of every successful athlete.</li>
          </ul>

          <p>
          Consistency is the secret weapon of every successful athlete. Whether you're just starting out or aiming for the next level, showing up every day makes all the difference. In this post, we'll dive into why consistency matters and how you can cultivate it to unlock your full potential.
          </p>

          <div class="quote">
            <div class="quote-text">
              “Calisthenics is a journey, not a destination. Stay consistent, trust the process, and remember—every effort you make today brings you one step closer to achieving your goals.”
            </div>

            <div class="quote-author">
              <span class="quote-author-name">Dominik Klimek</span>
              <span class="quote-author-title">CEO of Microsoft</span>
            </div>
          </div>
        </article>

        <aside class="sticky top-[20px] shrink-0 w-[416px] bg-white px-9 pt-10 pb-8 border border-[#EDEDED] rounded-[30px] min-h-[600px] flex flex-col">
          <h3 class="font-black text-2xl hfont">Registration form</h3>

          <button class="btn w-fit mt-auto mx-auto"  data-variant="primary">REGISTER & PROCEED TO CHECKOUT
          </button>
        </aside>
      </div>
    </div>
  </div>

  <div class="bg-white py-20 card-holder white relative">
    <div class="container-wrapper mb-12">
      <h4 class="text-primary font-semibold mb-7 max-lg:mb-6">READY FOR MORE? </h4>
      <div class="flex gap-4 max-lg:flex-col">
        <h2 class="text-3xl font-bold uppercase max-w-[500px] hfont max-lg:text-3xl">UPCOMING WORSHOPS</h2>
    
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
        {!! svgIcon("icon/icon-arrow.svg", ['class' => ['rotate-180']]) !!}
        </a>
      </div>  

      <div id="workshops-swiper" class="overflow-hidden w-full">
        <div class="swiper-wrapper">
          <div class="card swiper-slide">
            <div class="image-container">
              <img class="w-full h-full object-cover" src="https://loremflickr.com/455/219" alt="Dominik Klimek performing one arm handstand.">
            </div>

            <div class="tags">
              <span class="tag">Achievements</span>
              <span class="tag">Slovakia</span>
              <span class="tag">Self development</span>
            </div>

            <h3 class="title">Become a WSWCF certified calisthenics coach</h3>

            <p class="description">
              Join the World Association's Calisthenics Coach Certification Program.
              Enhance your skills, gain recognition, and advance your coaching career!
            </p>

            <div class="price-cta-container">
              <time>15. Marec 2024 - 15:48</time>
              <a href="#" class="cta-link text-primary">Read article</a>
            </div>
          </div>

          <div class="card swiper-slide">
            <div class="image-container">
              <img class="w-full h-full object-cover" src="https://loremflickr.com/455/219" alt="Dominik Klimek performing one arm handstand.">
            </div>

            <div class="tags">
              <span class="tag">Achievements</span>
              <span class="tag">Slovakia</span>
              <span class="tag">Self development</span>
            </div>

            <h3 class="title">Become a WSWCF certified calisthenics coach</h3>

            <p class="description">
              Join the World Association's Calisthenics Coach Certification Program.
              Enhance your skills, gain recognition, and advance your coaching career!
            </p>

            <div class="price-cta-container">
              <time>15. Marec 2024 - 15:48</time>
              <a href="#" class="cta-link text-primary">Read article</a>
            </div>
          </div>

          <div class="card swiper-slide">
            <div class="image-container">
              <img class="w-full h-full object-cover" src="https://loremflickr.com/455/219" alt="Dominik Klimek performing one arm handstand.">
            </div>

            <div class="tags">
              <span class="tag">Achievements</span>
              <span class="tag">Slovakia</span>
              <span class="tag">Self development</span>
            </div>

            <h3 class="title">Become a WSWCF certified calisthenics coach</h3>

            <p class="description">
              Join the World Association's Calisthenics Coach Certification Program.
              Enhance your skills, gain recognition, and advance your coaching career!
            </p>

            <div class="price-cta-container">
              <time>15. Marec 2024 - 15:48</time>
              <a href="#" class="cta-link text-primary">Read article</a>
            </div>
          </div>

          <div class="card swiper-slide">
            <div class="image-container">
              <img class="w-full h-full object-cover" src="https://loremflickr.com/455/219" alt="Dominik Klimek performing one arm handstand.">
            </div>

            <div class="tags">
              <span class="tag">Achievements</span>
              <span class="tag">Slovakia</span>
              <span class="tag">Self development</span>
            </div>

            <h3 class="title">Become a WSWCF certified calisthenics coach</h3>

            <p class="description">
              Join the World Association's Calisthenics Coach Certification Program.
              Enhance your skills, gain recognition, and advance your coaching career!
            </p>

            <div class="price-cta-container">
              <time>15. Marec 2024 - 15:48</time>
              <a href="#" class="cta-link text-primary">Read article</a>
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
  </div>
</section>

@endsection
