<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Support\Str;

class CourseService
{
    public function __construct(
        protected MediaService $mediaService,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Course
    {
        if (isset($data['image']) && $data['image'] !== null) {
            $data['image'] = $this->mediaService->storeImage($data['image'], 'courses');
        }

        $data['slug'] = $this->generateUniqueSlug($data['title']);
        $data['duration'] = $data['duration'] ?? $this->resolveDuration($data);
        $data['price'] = $data['price'] ?? 0;

        return Course::query()->create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Course $course, array $data): Course
    {
        $data['image'] = $this->mediaService->replaceImage(
            $course->image,
            $data['image'] ?? null,
            'courses',
        );

        if (isset($data['title']) && $this->resolveSlugSource($data['title']) !== $course->getTranslation('title')) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $course);
        }

        $data['duration'] = $data['duration'] ?? $course->duration ?? $this->resolveDuration($data);
        $data['price'] = $data['price'] ?? $course->price ?? 0;

        $course->update($data);

        return $course->refresh();
    }

    public function delete(Course $course): void
    {
        $this->mediaService->delete($course->image);
        $course->delete();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function resolveDuration(array $data): ?string
    {
        if (! blank($data['duration'] ?? null)) {
            return (string) $data['duration'];
        }

        if (! blank($data['hours'] ?? null)) {
            return (string) $data['hours'].' hours';
        }

        return null;
    }

    protected function generateUniqueSlug(string|array $title, ?Course $course = null): string
    {
        $baseSlug = Str::slug($this->resolveSlugSource($title));
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'course';
        $slug = $baseSlug;
        $suffix = 2;

        while (
            Course::query()
                ->where('slug', $slug)
                ->when($course !== null, static fn ($query) => $query->whereKeyNot($course->getKey()))
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }

    protected function resolveSlugSource(string|array $title): string
    {
        if (is_string($title)) {
            return $title;
        }

        return (string) ($title[config('app.fallback_locale', 'ru')]
            ?? $title['en']
            ?? $title['tg']
            ?? reset($title)
            ?: 'course');
    }
}
