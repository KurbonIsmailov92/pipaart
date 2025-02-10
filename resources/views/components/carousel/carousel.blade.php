<div id="carouselExampleCaptions" class="carousel slide mt-1 overflow-hidden rounded-xl shadow-lg carousel hidden sm:block" data-bs-ride="carousel">
    <div class="carousel-indicators">
        {{ $indicators }}
    </div>

    <div class="carousel-inner">
        {{ $items }}
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Предыдущий</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Следующий</span>
    </button>
</div>

