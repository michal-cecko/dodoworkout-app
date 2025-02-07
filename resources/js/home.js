import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs'

const heroSwiper = new Swiper('#hero-swiper', {
    slidesPerView: 1,
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
            document.getElementById('hero-swiper-current-page').textContent =
                this.activeIndex + 1
        },
        realIndexChange: function () {
            document.getElementById('hero-swiper-current-page').textContent =
                this.activeIndex + 1
        },
    }
})

const workshopsSwiper = new Swiper('#workshops-swiper', {
    slidesPerView: 1,
    loop: false,
    navigation: {
        nextEl: '#workshop-swiper-next',
        prevEl: '#workshop-swiper-prev'
    },
    breakpoints: {
        '768': {
            slidesPerView: 2,
        },
        '1400': {
            slidesPerView: 2.5,
        },
        '1700': {
            slidesPerView: 3,
        },
        '2100': {
            slidesPerView: 3.5,
        }
    }
})
