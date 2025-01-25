@extends('layouts.web')

@section('body')
<section id="blog" class="container-wrapper pt-10 pb-24 relative">
  <span class="block text-primary font-semibold mx-auto w-fit mb-7 uppercase">blog</span>
  <h1 class="hfont text-4xl font-black mb-7 text-center uppercase">Articles for Every Athlete</h1>
  <p class="text-textSecondary text-xl mb-7 text-center mx-auto max-w-[640px] mb-28">
  Explore my insights on workouts, skills, and mindset to elevate your training and transform your approach to calisthenics.
  </p>
  <div class="flex gap-14">
    <aside class="w-[222px] shrink-0">
      <div class="mt-2 border border-[#DDDDDDEE] rounded-lg text-sm overflow-hidden flex pl-3 h-[36px] bg-white items-center focus-within:ring-2 focus-within:ring-primary mb-4">
        {!! svgIcon("icon/icon-search.svg", ['class' => ['text-[#AAAAAAEE]']]) !!}

        <input type="search" class="w-full bg-tranparent border-none outline-none pl-3" placeholder="Vyhľadať" />
      </div>

      <button class="text-xs px-3 py-2 mb-2">Reset filters</button>

      <div class="filter-container">
        <h5 class="filter-heading">Availability</h5>

        <label class="filter-label">
          <input type="checkbox" class="filter-checkbox" name="availability" checked value="free">
          Free
        </label>

        <label class="filter-label">
          <input type="checkbox" class="filter-checkbox" name="availability" value="premium">
          Premium
        </label>
      </div>

      <div class="filter-container">
        <h5 class="filter-heading">Tags</h5>

        <label class="filter-label">
          <input type="checkbox" class="filter-checkbox" name="tags" checked value="achievements">
          Achievements
        </label>
        <label class="filter-label">
          <input type="checkbox" class="filter-checkbox" name="tags" value="mindset">
          Mindset
        </label>
        <label class="filter-label">
          <input type="checkbox" class="filter-checkbox" name="tags" value="workout">
          Workout
        </label>
        <label class="filter-label">
          <input type="checkbox" class="filter-checkbox" name="tags" value="skills">
          Skills
        </label>
        <label class="filter-label">
          <input type="checkbox" class="filter-checkbox" name="tags" value="recovery">
          Recovery
        </label>        
        <label class="filter-label">
          <input type="checkbox" class="filter-checkbox" name="tags" value="planche">
          Planche
        </label>        
        <label class="filter-label">
          <input type="checkbox" class="filter-checkbox" name="tags" value="coaching">
          Coaching
        </label>        
        <label class="filter-label">
          <input type="checkbox" class="filter-checkbox" name="tags" value="competitions">
          Competitions
        </label>
      </div>
    </aside>

    <div class="pt-4 card-holder white w-full">
      <div class="mb-7 text-sm flex gap-6 items-center">
        <span class="text-textSecondary font-semibold">Active filters</span>
        <div class="flex gap-2 items-center text-xs font-medium">
          <div class="bg-primary text-white flex items-center gap-2 px-3 py-2 leading-0 rounded-xl">
            Achievements

            <span>&times;</span>
          </div>
          <div class="bg-primary text-white flex items-center gap-2 px-3 py-2 leading-0 rounded-xl">
            Free
            <span>&times;</span>
          </div>    
        </div>
      </div>

      <div class="grid grid-cols-2 gap-10">
        <!-- Cez data atribut highlight vies zapnut highlight layout -->
        <div class="card" data-highlight="true">
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
        <div class="card">
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
        <div class="card">
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
        <div class="card">
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
        <div class="card">
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
  <div class="flex justify-center mt-auto pt-24">
    <button class="btn" data-variant="primary">Load more</button>
  </div>

  {!! svgIcon("svg/triangle-mesh.svg", ['class' => ['max-lg:hidden absolute top-[60%] w-[calc(100vw * 2)] text-[#FFC1C1]']]) !!}
  {!! svgIcon("svg/dots-mesh.svg", ['class' => ['max-lg:hidden absolute right-10 top-[10%] w-[calc(100vw * 2)] text-[#D9D9D9]']]) !!}
  {!! svgIcon("svg/dots-mesh.svg", ['class' => ['max-lg:hidden z-[-1] absolute top-1/5 right-20 w-[calc(100vw * 2)] text-[#D9D9D9]']]) !!}

</section>

@endsection
