@php use App\Services\LocaleService; @endphp
@extends('layouts.web')

@section('body')
    <section id="bootcamp">
        <div
            class="h-[512px] bg-primary"
            style="background: {{$event->getFirstMediaUrl("image") ? "url('{$event->getFirstMediaUrl("image")}')" : "#fff"}} 50% / cover no-repeat;">
        </div>

        <div class="pb-24">
            <div class="-mt-[100px] max-w-[1027px] mx-auto">
                <div
                    class="bg-white relative px-11 rounded-[30px] border border-[#EDEDED] grid grid-cols-3 mb-14 max-lg:grid-cols-1 max-lg:px-0">
                    <div class="col-span-2 pr-11 py-11 max-lg:col-span-1 max-lg:px-6 workshop-left">
                        <div class="flex gap-9 items-start mb-4">
                            <div
                                class="date-badge bg-[#F8F8F8] max-lg:!w-16 shrink-0 max-lg:absolute top-[-2px] right-6 max-lg:-translate-y-1/2"
                                data-variant="lg">
                                <span
                                    class="month max-lg:!text-base max-lg:!py-1">{{ $event->start_at->translatedFormat("M") }}</span>
                                <span
                                    class="day max-lg:!text-xl border-x border-b border-[#ececec]">{{ $event->start_at->format("d") }}</span>
                            </div>
                            <div>
                                @if(!empty($event->category))
                                    <span
                                        class="uppercase text-sm text-textSecondary mb-3">{{ $event->category->name }}</span>
                                @endif
                                <h2 class="hfont text-3xl font-black max-lg:text-2xl">{{ $event->title }}</h2>
                            </div>
                        </div>

                        @if(!empty($event->excerpt))
                            <p class="text-sm text-textSecondary mb-10">
                                {{ $event->excerpt }}
                            </p>
                        @endif

                        <div class="flex gap-12 max-lg:gap-5">
                            @if(!empty($event->address))
                                <div class="text-textSecondary text-lg max-lg:text-sm">
                                    <div
                                        class="text-primary font-bold text-sm flex items-center gap-3 mb-1 max-lg:mb-2">
                                        {!! svgIcon("icon/icon-map_marker.svg") !!}
                                        {{ __("address") }}
                                    </div>
                                    {{ $event->address }}
                                </div>
                            @endif

                            <div class="text-textSecondary text-lg max-lg:text-sm">
                                <div class="text-primary font-bold text-sm flex items-center gap-3 mb-1 max-lg:mb-2">
                                    {!! svgIcon("icon/icon-calendar.svg") !!}
                                    {{__("event_date_from_to_label")}}
                                </div>
                                @if($event->start_at->diffInDays($event->end_at) > 0)
                                    {{ $event->start_at->translatedFormat("d. F Y") }}
                                    - {{ $event->end_at->translatedFormat("d. F Y") }}
                                @else
                                    {{ $event->start_at->translatedFormat("d. F Y") }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-span-1 flex flex-col pl-11 py-11 workshop-right max-lg:px-6 max-lg:pb-8">
                        @if(!empty($event->last_price))
                            <span
                                class="sale-tag mb-5 max-lg:absolute top-0 left-6 -translate-y-1/2">{{__("sale_tag")}}</span>
                        @endif
                        <h3 class="font-black text-3xl hfont max-lg:text-2xl max-lg:mb-8">
                            <span class="highlight">{{__("event_register_cta_partial")}},</span><br
                                class="max-lg:hidden"/>{{__("still_places_left", ["count" => 5])}}
                        </h3>

                        <div class="flex mt-auto">
                            <div>
                                @if(!empty($event->last_price))
                                    <div class="text-lg line-through text-textSecondary">{{ (float) $event->last_price }} €</div>
                                    <div class="text-2xl font-bold text-primary">{{(float) $event->price}} €</div>
                                @else
                                    <div class="text-2xl font-semibold text-textSecondary">{{ (float) $event->price }} €</div>
                                @endif

                            </div>

                            <button class="btn self-end ml-auto" data-variant="primary">{{__("register_now")}}
                                {!! svgIcon("icon/icon-lucide_arrow.svg") !!}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex gap-12 items-start pl-11 max-lg:gap-3 max-lg:px-0 max-lg:flex-col">
                    <article class="w-full max-lg:px-6">
                        @include("parts.builder", ['contents' => $event->content])
                    </article>

                    <aside
                        class="sticky top-[20px] shrink-0 w-[416px] max-lg:w-full bg-white px-9 pt-10 pb-8 border border-[#EDEDED] rounded-[30px] min-h-[600px] flex flex-col max-lg:px-6">
                        <h3 class="font-black text-2xl hfont">{{__("registration_form")}}</h3>

                        <button class="btn w-fit mt-auto mx-auto" data-variant="primary">{{__("register_and_proceed_to_checkout")}}</button>
                    </aside>
                </div>
            </div>
        </div>

        @if($relatedEvents->isNotEmpty())
            <div class="bg-white py-20 card-holder white relative">
                <div class="container-wrapper mb-12">
                    <h4 class="text-primary font-semibold mb-7 max-lg:mb-6">{{__("event_related_subheading")}}</h4>
                    <div class="flex gap-4 max-lg:flex-col">
                        <h2 class="text-3xl font-bold uppercase max-w-[500px] hfont max-lg:text-3xl">{{__("event_related_heading")}}</h2>

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
                        <a href="{{ LocaleService::getLocalizedRoutePathByName("events") }}" class="btn self-start whitespace-nowrap" data-variant="primary">
                            {{__("view_all")}}
                            {!! svgIcon("icon/icon-arrow.svg", ['class' => ['rotate-180']]) !!}
                        </a>
                    </div>

                    <div id="workshops-swiper" class="overflow-hidden w-full">
                        <div class="swiper-wrapper">
                            @foreach($relatedEvents as $event)
                                <div class="px-3 max-md:px-6 swiper-slide">
                                    @include("parts.event-card", ["event" => $event])
                                </div>
                            @endforeach
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
        @endif
    </section>

@endsection
