@extends('layouts.web')

@section('body')
    <section id="blog" class="pt-10 pb-24 relative flex flex-col max-lg:pt-0">
        <div
            class="container-wrapper relative max-lg:order-2 max-lg:pt-6 max-lg:-mt-6 z-[20] max-lg:rounded-3xl bg-white max-lg:px-6 max-lg:!max-w-full">
            <span
                class="block text-primary font-semibold mx-auto w-fit mb-3 uppercase max-lg:mx-0 max-lg:text-sm max-lg:mt-6">blog</span>
            <h1 class="hfont text-4xl font-black mb-7 text-center max-lg:text-2xl max-lg:text-left">
                {{$post->title}}
            </h1>
            <div class="flex gap-2 items-center mb-11 justify-center max-lg:justify-start max-lg:mb-0">
                <time class="mr-6 text-textSecondary max-lg:text-xs">{{$post->created_at->format("j. N Y - H:i")}}</time>

                <button
                    class="flex items-center border border-[#EDEDED] p-[6px] bg-[#F8F8F8] text-sm gap-1 rounded-lg h-6">
                    {!! svgIcon("icon/icon-like.svg", ['class' => ['']]) !!}
                    @if(!empty($post->likes))
                        <span>{{$post->likes}}</span>
                    @endif
                </button>

                <button
                    class="flex items-center border border-[#EDEDED] p-[6px] bg-[#F8F8F8] text-sm gap-1 rounded-lg h-6">
                    {!! svgIcon("icon/icon-like.svg", ['class' => ['rotate-180 scale-x-[-1]']]) !!}
                </button>
            </div>

            {!! svgIcon("svg/dots-mesh.svg", ['class' => ['max-lg:hidden absolute left-10 top-[10%] w-[calc(100vw * 2)] text-[#D9D9D9]']]) !!}

        </div>

        @if($image = $post->getFirstMedia("image"))
            <div class="relative isolate max-lg:order-1">
                <div
                    class="absolute max-h-[240px] top-1/2 -translate-y-1/2 left-0 w-full h-full bg-primary z-[-1] max-lg:hidden"></div>
                <div class="h-[414px] max-w-[1098px] mx-auto rounded-3xl overflow-hidden max-lg:rounded-none">
                    <img class="w-full h-full object-cover"
                         src="{{$image->getFullUrl()}}"
                         alt="{{$post->title}}">
                </div>
            </div>
        @endif

        <div class="container-wrapper mt-12 order-3">
            <article class="w-full max-w-[697px] mx-auto max-lg:!max-w-full">

                @include("parts.builder", ['contents' => $post->content])

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
            <div class="max-lg:mx-auto"
                 style="padding-left: max(calc((100vw - var(--max-container-width)) / 2), var(--container-padding));">
                <a href="#" class="btn self-start whitespace-nowrap" data-variant="primary">
                    view all
                    {!! svgIcon("icon/icon-arrow.svg", ['class' => ['rotate-180']]) !!}
                </a>
            </div>

            <div id="workshops-swiper" class="overflow-hidden w-full">
                <div class="swiper-wrapper">
                    <div class="swiper-slide px-3 max-md:px-6">
                        <div class="card">
                            <div class="image-container">
                                <img class="w-full h-full object-cover" src="https://loremflickr.com/455/219"
                                     alt="Dominik Klimek performing one arm handstand.">
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

                    <div class="swiper-slide px-3 max-md:px-6">
                        <div class="card">
                            <div class="image-container">
                                <img class="w-full h-full object-cover" src="https://loremflickr.com/455/219"
                                     alt="Dominik Klimek performing one arm handstand.">
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

                    <div class="swiper-slide px-3 max-md:px-6">
                        <div class="card">
                            <div class="image-container">
                                <img class="w-full h-full object-cover" src="https://loremflickr.com/455/219"
                                     alt="Dominik Klimek performing one arm handstand.">
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

                    <div class="swiper-slide px-3 max-md:px-6">
                        <div class="card">
                            <div class="image-container">
                                <img class="w-full h-full object-cover" src="https://loremflickr.com/455/219"
                                     alt="Dominik Klimek performing one arm handstand.">
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
        </div>

        {!! svgIcon("svg/progress.svg", ['class' => ['max-lg:hidden absolute top-[50%] w-[calc(100vw * 2)]']]) !!}

        <script type="module" defer>
            import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs'

            const swiper = new Swiper('#workshops-swiper', {
                slidesPerView: 1,
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
