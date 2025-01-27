@extends('layouts.web')

@section('body')
<section id="blog" class="pt-10 pb-24 relative flex flex-col max-lg:pt-0">
  <div class="container-wrapper relative max-lg:order-2 max-lg:pt-6 max-lg:-mt-6 z-[20] max-lg:rounded-3xl bg-white max-lg:px-6 max-lg:!max-w-full">
    <span class="block text-primary font-semibold mx-auto w-fit mb-3 uppercase max-lg:mx-0 max-lg:text-sm max-lg:mt-6">blog</span>
    <h1 class="hfont text-4xl font-black mb-7 text-center max-lg:text-2xl max-lg:text-left">I was nominated to be sportsman of the year</h1>
    <div class="flex gap-2 items-center mb-11 justify-center max-lg:justify-start max-lg:mb-0">
      <time class="mr-6 text-textSecondary max-lg:text-xs">15. Marec 2024 - 15:48</time>
  
      <button class="flex items-center border border-[#EDEDED] p-[6px] bg-[#F8F8F8] text-sm gap-1 rounded-lg h-6">
        {!! svgIcon("icon/icon-like.svg", ['class' => ['']]) !!}
        <span>10</span>
      </button>
  
      <button class="flex items-center border border-[#EDEDED] p-[6px] bg-[#F8F8F8] text-sm gap-1 rounded-lg h-6">
        {!! svgIcon("icon/icon-like.svg", ['class' => ['rotate-180 scale-x-[-1]']]) !!}
      </button>
    </div>

    {!! svgIcon("svg/dots-mesh.svg", ['class' => ['max-lg:hidden absolute left-10 top-[10%] w-[calc(100vw * 2)] text-[#D9D9D9]']]) !!}

  </div>

  <div class="relative isolate max-lg:order-1">
    <div class="absolute max-h-[240px] top-1/2 -translate-y-1/2 left-0 w-full h-full bg-primary z-[-1] max-lg:hidden"></div>
    <div class="h-[414px] max-w-[1098px] mx-auto rounded-3xl overflow-hidden max-lg:rounded-none">
      <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="Dominik Klimek performing one arm handstand.">
    </div>
  </div>

  <div class="container-wrapper mt-12 order-3">
    <article class="w-full max-w-[697px] mx-auto max-lg:!max-w-full">
      <h1>Heading 1</h1>

      <p>
        Consistency is the secret weapon of <b>every successful athlete</b>. Whether you're just starting out
        or aiming for the next level, showing up <a href="#">every day makes</a> all the difference.
        In this post, we'll dive into why consistency matters and how you can cultivate it to unlock your full
        potential.
      </p>

      <h2>Heading 2</h2>

      <p>
        Consistency is the secret weapon of every successful athlete. Whether you're just
        starting out or aiming for the next level, showing up every day makes all the difference.
        In this post, we'll dive into why consistency matters and how you can cultivate it to unlock your
        full potential.
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
        Consistency is the secret weapon of every successful athlete. Whether you're just
        starting out or aiming for the next level, showing up every day makes all the difference.
        In this post, we'll dive into why consistency matters and how you can cultivate it to unlock your full
        potential.
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

      <h3>Heading 3</h3> 

      <p>
        Consistency is the secret weapon of every successful athlete. Whether you're just starting
        out or aiming for the next level, showing up every day makes all the difference. In this post,
        we'll dive into why consistency matters and how you can cultivate it to unlock your full potential.
      </p>

      <h3>Gallery of dominik the muskľe</h3>

      <div class="gallery">
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="Dominik Klimek performing one arm handstand.">
        </div>
        <div class="gallery-item">
          <img src="https://loremflickr.com/320/240/nature?lock=1" alt="Dominik Klimek performing one arm handstand.">
        </div>
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="Dominik Klimek performing one arm handstand.">
        </div>
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="Dominik Klimek performing one arm handstand.">
        </div>
        <div class="gallery-item">
          <img src="https://loremflickr.com/320/240/nature?lock=1" alt="Dominik Klimek performing one arm handstand.">
        </div>
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="Dominik Klimek performing one arm handstand.">
        </div>
        <div class="gallery-item">
          <img src="https://loremflickr.com/320/240/nature?lock=1" alt="Dominik Klimek performing one arm handstand.">
        </div>
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="Dominik Klimek performing one arm handstand.">
        </div>
      </div>

      <h3>Heading 3</h3> 

      <p>
        Consistency is the secret weapon of every successful athlete. Whether you're just starting out or
        aiming for the next level, showing up every day makes all the difference. In this post, we'll
        dive into why consistency matters and how you can cultivate it to unlock your full potential.
      </p>

      <div class="tags">
        <span class="tag">Achievements</span>
        <span class="tag">Slovakia</span>
        <span class="tag">Self development</span>
      </div>
    </article>
  </div>
</section>

<div class="bg-white py-20 card-holder gray relative">
  <div class="container-wrapper mb-12">
    <h4 class="text-primary font-semibold mb-7 max-lg:mb-6">READY FOR MORE? </h4>
    <div class="flex gap-4 max-lg:flex-col">
      <h2 class="text-3xl font-bold uppercase max-w-[500px] hfont max-lg:text-3xl">UPCOMING WORSHOPS</h2>
  
      <div class="flex gap-4 ml-auto items-center text-[#B2B2B2] justify-between max-lg:ml-0">
        <button id="workshop-swiper-prev" class="swiper-button">
        {!! svgIcon("icon/icon-arrow.svg") !!}
        </button>
        <button id="workshop-swiper-next" class="swiper-button">
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
        '1280': {
          slidesPerView: 3,
        }
      }
    })
  </script>
</div>

@endsection
