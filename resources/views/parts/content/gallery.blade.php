@if(!empty($images = ($content['data']['images'] ?? null)))
    <div class="gallery">
        @foreach($images as $image)
            <div class="gallery-item">
                <img src="{{$image}}" alt="">
            </div>
        @endforeach
    </div>
@endif
