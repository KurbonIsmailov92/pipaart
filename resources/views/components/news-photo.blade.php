@props(['news', 'width' => 90, 'src'=>'https://picsum.photos/500/400'])

<img src="{!! $src !!}"
     alt="photo"
     class="rounded-xl border-black"
     width="{{ $width }}">
