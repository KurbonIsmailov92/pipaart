<?php

use App\Services\GalleryService;

it('renders the public gallery page when there are no photos', function (): void {
    $this->get('/ru/gallery')
        ->assertOk();
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
