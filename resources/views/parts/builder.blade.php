@foreach($contents as $content)
    @switch($content['type'])
        @case("image")
            @include("parts.content.media", ['content' => $content])
            @break
        @case("content")
            @include("parts.content.content", ['content' => $content])
            @break
        @case("blockquote")
            @include("parts.content.quote", ['content' => $content])
            @break
        @case("blockquote")
            @include("parts.content.quote", ['content' => $content])
            @break
        @case("gallery")
            @include("parts.content.gallery", ['content' => $content])
            @break
    @endswitch
@endforeach
