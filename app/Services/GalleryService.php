<?php

namespace App\Services;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class GalleryService
{
    public function __construct(
        protected MediaService $mediaService,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Gallery
    {
        $file = $data['image_path'] ?? $data['image'] ?? null;

        if ($file !== null) {
            $storedPath = $this->mediaService->storeImage($file, 'gallery');
            $data['image_path'] = $storedPath;
            $data['image'] = $storedPath;
        }

        $data['slug'] = $this->generateUniqueSlug((string) $data['title']);
        $data['category'] = $data['category'] ?? 'general';

        return Gallery::query()->create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Gallery $gallery, array $data): Gallery
    {
        $file = $data['image_path'] ?? $data['image'] ?? null;

        $storedPath = $this->mediaService->replaceImage(
            $gallery->image_path ?: $gallery->image,
            $file,
            'gallery',
        );

        $data['image_path'] = $storedPath;
        $data['image'] = $storedPath;
        $data['category'] = $data['category'] ?? $gallery->category ?? 'general';

        if (isset($data['title']) && $data['title'] !== $gallery->title) {
            $data['slug'] = $this->generateUniqueSlug((string) $data['title'], $gallery);
        }

        $gallery->update($data);

        return $gallery->refresh();
    }

    public function delete(Gallery $gallery): void
    {
        $this->mediaService->delete($gallery->image_path ?: $gallery->image);
        $gallery->delete();
    }

    public function paginatePublic(int $perPage = 12): LengthAwarePaginator
    {
        return Gallery::query()->ordered()->paginate($perPage);
    }

    public function latestPublic(int $limit = 6): Collection
    {
        return Gallery::query()
            ->ordered()
            ->limit($limit)
            ->get();
    }

    protected function generateUniqueSlug(string $title, ?Gallery $gallery = null): string
    {
        $baseSlug = Str::slug($title);
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'gallery';
        $slug = $baseSlug;
        $suffix = 2;

        while (
            Gallery::query()
                ->where('slug', $slug)
                ->when($gallery !== null, static fn ($query) => $query->whereKeyNot($gallery->getKey()))
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }
}
