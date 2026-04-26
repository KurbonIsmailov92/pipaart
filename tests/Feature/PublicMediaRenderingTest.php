<?php

use App\Models\Course;
use App\Models\Gallery;
use App\Models\NewsPost;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Vite;

beforeEach(function (): void {
    Storage::fake('public');
});

it('renders uploaded gallery images on admin and public pages', function (): void {
    $locale = 'ru';
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.gallery.store'), [
            'title' => 'Gallery upload',
            'category' => 'events',
            'description' => 'Gallery upload description',
            'image_path' => UploadedFile::fake()->image('gallery.jpg'),
        ])
        ->assertRedirect(route('admin.gallery.index'));

    $photo = Gallery::query()->firstOrFail();

    Storage::disk('public')->assertExists($photo->image_path);
    expect($photo->image_url)->not->toBeNull();

    $this->get(parse_url((string) $photo->image_url, PHP_URL_PATH) ?: '')
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.gallery.index'))
        ->assertOk()
        ->assertSee($photo->image_url, false);

    $this->actingAs($admin)
        ->get(route('admin.gallery.edit', $photo))
        ->assertOk()
        ->assertSee($photo->image_url, false);

    $this->get(route('gallery.index', ['locale' => $locale]))
        ->assertOk()
        ->assertSee($photo->image_url, false);

    $this->get(route('gallery.show', ['locale' => $locale, 'gallery' => $photo]))
        ->assertOk()
        ->assertSee($photo->image_url, false);
});

it('renders uploaded news images on admin and public pages', function (): void {
    $locale = 'ru';
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.news.store'), [
            'title' => [
                'ru' => 'Новость с фото',
                'tg' => 'Хабар бо сурат',
                'en' => 'News with image',
            ],
            'content' => [
                'ru' => 'Контент новости',
                'tg' => 'Матни хабар',
                'en' => 'News body',
            ],
            'published_at' => now()->format('Y-m-d H:i:s'),
            'image' => UploadedFile::fake()->image('news.jpg'),
        ])
        ->assertRedirect(route('admin.news.index'));

    $newsPost = NewsPost::query()->firstOrFail();

    Storage::disk('public')->assertExists($newsPost->image);
    expect($newsPost->image_url)->not->toBeNull();

    $this->get(parse_url((string) $newsPost->image_url, PHP_URL_PATH) ?: '')
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.news.index'))
        ->assertOk()
        ->assertSee($newsPost->image_url, false);

    $this->actingAs($admin)
        ->get(route('admin.news.edit', $newsPost))
        ->assertOk()
        ->assertSee($newsPost->image_url, false);

    $this->get(route('news.list', ['locale' => $locale]))
        ->assertOk()
        ->assertSee($newsPost->image_url, false);

    $this->get(route('news.show', ['locale' => $locale, 'newsPost' => $newsPost]))
        ->assertOk()
        ->assertSee($newsPost->image_url, false);
});

it('renders uploaded course images on admin and public pages', function (): void {
    $locale = 'ru';
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.courses.store'), [
            'title' => [
                'ru' => 'Курс с фото',
                'tg' => 'Курс бо сурат',
                'en' => 'Course with image',
            ],
            'description' => [
                'ru' => 'Описание курса',
                'tg' => 'Тавсифи курс',
                'en' => 'Course description',
            ],
            'duration' => '24 hours',
            'hours' => 24,
            'price' => 150,
            'image' => UploadedFile::fake()->image('course.jpg'),
        ])
        ->assertRedirect(route('admin.courses.index'));

    $course = Course::query()->firstOrFail();

    Storage::disk('public')->assertExists($course->image);
    expect($course->image_url)->not->toBeNull();

    $this->get(parse_url((string) $course->image_url, PHP_URL_PATH) ?: '')
        ->assertOk();

    $this->actingAs($admin)
        ->get(route('admin.courses.index'))
        ->assertOk()
        ->assertSee($course->image_url, false);

    $this->actingAs($admin)
        ->get(route('admin.courses.edit', $course))
        ->assertOk()
        ->assertSee($course->image_url, false);

    $this->get(route('courses.index', ['locale' => $locale]))
        ->assertOk()
        ->assertSee($course->image_url, false);

    $this->get(route('courses.show', ['locale' => $locale, 'course' => $course]))
        ->assertOk()
        ->assertSee($course->image_url, false);
});

it('renders fallback images when uploaded media is missing', function (): void {
    $locale = 'ru';
    $gallery = Gallery::query()->create([
        'title' => 'Gallery fallback',
        'slug' => 'gallery-fallback',
        'category' => 'general',
        'description' => 'No image attached',
        'image' => '',
        'image_path' => null,
    ]);

    $newsPost = NewsPost::factory()->create([
        'image' => null,
    ]);

    $course = Course::factory()->create([
        'image' => null,
    ]);

    $galleryFallback = Vite::asset('resources/images/cap.jpg');
    $newsFallback = Vite::asset('resources/images/news.jpg');
    $courseFallback = Vite::asset('resources/images/cipa.jpg');

    $this->get(route('gallery.show', ['locale' => $locale, 'gallery' => $gallery]))
        ->assertOk()
        ->assertSee($galleryFallback, false);

    $this->get(route('news.show', ['locale' => $locale, 'newsPost' => $newsPost]))
        ->assertOk()
        ->assertSee($newsFallback, false);

    $this->get(route('courses.show', ['locale' => $locale, 'course' => $course]))
        ->assertOk()
        ->assertSee($courseFallback, false);
});
