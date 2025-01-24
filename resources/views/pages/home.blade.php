@extends('layouts.web')

@section('body')
    <section id="hp_hero">

        {!! svgIcon("svg/dots-mesh.svg", ['class' => ['dots-mesh']]) !!}

        {!! svgIcon("svg/dots-mesh.svg", ['class' => ['striped-circle']]) !!}

        <div class="red-rectangle"></div>

        <div class="swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="text-content">
                        <h1>From the <b>World's Stage</b> to Your <span>Training Plan</span></h1>
                        <div class="buttons">
                            <a class="btn btn-primary" href="#">My offer</a>
                            <a class="btn btn-text" href="#">About me</a>
                        </div>
                        <div class="lower-content">
                            <p>As the 2022 World Calisthenics Champion, I bring elite skills in strength and freestyle.
                                Through coaching, eBooks, and seminars, I help athletes push limits and achieve their
                                goals.</p>
                            <div class="socials-container">
                                @include('parts.socials')
                            </div>
                        </div>
                    </div>

                    <div class="image-content">
                        <img src="image/hp-hero-placeholder.jpg" alt="Dominik klimek performing one arm handstand.">
                    </div>
                </div>
            </div>

            <div class="navigation-container">
                <div class="prev"></div>
                <div class="page">1/4</div>
                <div class="next"></div>
            </div>
        </div>
    </section>
@endsection
