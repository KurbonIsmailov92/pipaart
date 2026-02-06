@props(['image', 'title', 'isActive' => false])

<div class="carousel-item {{ $isActive ? 'active' : '' }} position-relative">
    <img src="{{ $image }}" class="d-block w-100 rounded-xl" alt="{{ $title }}" loading="{{ $isActive ? 'eager' : 'lazy' }}" decoding="async">
    <div
        class="carousel-caption d-none d-md-block bg-white/50 rounded-xl position-absolute pb-2"
        style="left: 20px; bottom: 20px; max-width: 50%;"
    >
        <h1 class="ml-4 font-bold text-left text-blue-900 text-2xl sm:text-4xl">{{ $title }}</h1>
    </div>
</div>



