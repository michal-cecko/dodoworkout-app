<a href="{{$article->permalink}}">
    <div class="card">
        <div class="image-container">
            <img class="w-full h-full object-cover" src="{{$article->getFirstMediaUrl("image")}}"
                 alt="{{$article->title}}">
        </div>

        @if($article->tags->isNotEmpty())
            <div class="tags">
                @foreach($article->tags as $tag)
                    <span class="tag">{{$tag->name}}</span>
                @endforeach
            </div>
        @endif

        <h3 class="title">{{$article->title}}</h3>

        @if(!empty($article->description))
            <p class="description"> {{$article->description}} </p>
        @endif

        <div class="price-cta-container">
            <time>{{$article->published_at->translatedFormat("j. F Y - H:i")}}</time>
            <span class="cta-link text-primary">{{__("read_article")}}</span>
        </div>
    </div>
</a>
