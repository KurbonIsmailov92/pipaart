@props(['slidesCount'])

@for ($i = 0; $i < $slidesCount; $i++)
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $i }}"
            class="{{ $i === 0 ? 'active' : '' }}"
            aria-current="{{ $i === 0 ? 'true' : 'false' }}"
            aria-label="Слайд {{ $i + 1 }}"></button>
@endfor
