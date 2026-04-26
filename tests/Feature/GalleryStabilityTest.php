<?php

use App\Models\Gallery;
use App\Services\GalleryService;
use Illuminate\Support\Facades\Route;

it('renders the public gallery page when there are no photos', function (): void {
    $this->get('/ru/gallery')
        ->assertOk();
});

it('renders the oipba gallery page through the shared gallery service', function (): void {
    $photo = Gallery::query()->create([
        'title' => 'OIPBA photo',
        'slug' => 'oipba-photo',
        'category' => 'general',
        'description' => 'Shared gallery item',
        'image' => 'gallery/missing-oipba.jpg',
        'image_path' => 'gallery/missing-oipba.jpg',
    ]);

    $this->get('/ru/oipba/gallery')
        ->assertOk()
        ->assertSee($photo->title);
});

it('renders the public gallery detail page', function (): void {
    $photo = Gallery::query()->create([
        'title' => 'Gallery detail',
        'slug' => 'gallery-detail',
        'category' => 'general',
        'description' => 'Gallery detail description',
        'image' => 'gallery/missing-detail.jpg',
        'image_path' => 'gallery/missing-detail.jpg',
    ]);

    $this->get(route('gallery.show', ['locale' => 'ru', 'gallery' => $photo]))
        ->assertOk()
        ->assertSee($photo->title);
});

it('does not expose destructive public gallery routes', function (): void {
    $destructiveRoutes = collect(Route::getRoutes()->getRoutes())
        ->filter(function ($route): bool {
            $methods = collect($route->methods());

            return str_starts_with($route->uri(), '{locale}/gallery')
                && $methods->contains(fn (string $method): bool => in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'], true));
        });

    expect($destructiveRoutes)->toHaveCount(0);
});

it('does not swallow gallery exceptions', function (): void {
    $this->withoutExceptionHandling();

    $galleryService = \Mockery::mock(GalleryService::class);
    $galleryService->shouldReceive('paginatePublic')
        ->once()
        ->andThrow(new RuntimeException('Gallery query failed.'));

    app()->instance(GalleryService::class, $galleryService);

    expect(fn () => $this->get('/ru/gallery'))
        ->toThrow(RuntimeException::class, 'Gallery query failed.');
});
