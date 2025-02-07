@php use App\Services\LocaleService; @endphp
<footer class="border-t border-[#EEE5E5] pt-20 mt-auto bg-white max-lg:pt-10">
  <div class="container-wrapper flex gap-24 mb-10 max-lg:flex-col max-lg:gap-10">
    <div class="relative">
      <div class="logo-container mb-7">{!! svgIcon("logo/logo-black-red.svg", ['class' => ['h-[46px] w-[110px] max-lg:h-[34px] max-lg:w-[81px]']]) !!}</div>
      <a class="flex items-center gap-3 mb-4" href="mailto:me@dodoworkout.com">
      {!! svgIcon("icon/mail.svg") !!}
        me@dodoworkout.com
      </a>
      <a class="flex items-center gap-3 mb-8" href="tel:+421 911 266 631">
      {!! svgIcon("icon/phone.svg", ['class' => ['text-primary']]) !!}
        +421 911 266 631
      </a>
      <div class="flex gap-6 items-center text-[#373737]">
          @include('parts.socials')
      </div>
      {!! svgIcon("svg/striped-circle.svg", ['class' => ['text-[#F4F4F4] absolute z-[-1] right-0 top-[10%]']]) !!}
    </div>
    <div class="grid grid-cols-3 gap-40 w-full max-lg:grid-cols-1 max-lg:gap-10">
      <div>
        <h5 class="mb-5 uppercase text-primary font-bold">About</h5>
        <p class="max-w-[181px]">Mgr. Dominik Klimek,
          profesional calisthenics
          athlete and coach.
          <a href="#" class="block font-bold text-primary">Read more</a>
          <br />
          IČO: 36396885</br>
          IČ DPH: SK 2021556845
        </p>
      </div>
      <div>
        <h5 class="mb-5 uppercase text-primary font-bold">Links</h5>
        <ul class="flex flex-col gap-3">
          <li><a href="{{ LocaleService::localizePath("/blog") }}">Blog</a></li>
          {{--<li><a href="#">Personal / online training</a></li>--}}
          <li><a href="{{ LocaleService::localizePath("/events") }}">Seminars & certifications</a></li>
          {{--<li><a href="#">Shop</a></li>--}}
          {{--<li><a href="#">About</a></li>--}}
          {{--<li><a href="#">Contact</a></li>--}}
        </ul>
      </div>
      <div>
        <h5 class="mb-5 uppercase text-primary font-bold">information</h5>
        <ul class="flex flex-col gap-3">
          <li><a href="#">Return policy</a></li>
          <li><a href="#">Privacy policy</a></li>
          <li><a href="#">Business conditions</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="bg-[#F8F8F8] border-t border-[#EEE5E5] h-12 flex items-center justify-center">
    Copyright © 2024 | DODOWORKOUT
  </div>
</footer>
