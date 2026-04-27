<?php

use App\Models\Course;
use App\Models\Gallery;
use App\Models\NewsPost;
use App\Models\Page;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake('public');
});

it('admin can create a page', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.pages.store'), [
            'slug' => 'new-page',
            'title' => [
                'ru' => 'New Page',
                'tg' => 'New Page TG',
                'en' => 'New Page EN',
            ],
            'content' => [
                'ru' => 'Page content',
                'tg' => 'Page content TG',
                'en' => 'Page content EN',
            ],
            'meta_title' => [
                'ru' => 'Meta',
                'tg' => 'Meta TG',
                'en' => 'Meta EN',
            ],
            'meta_description' => [
                'ru' => 'Meta description',
                'tg' => 'Meta description TG',
                'en' => 'Meta description EN',
            ],
            'is_published' => 1,
        ])
        ->assertRedirect(route('admin.pages.index'));

    expect(Page::query()->where('slug', 'new-page')->exists())->toBeTrue();
});

it('admin can create a course', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.courses.store'), [
            'title' => [
                'ru' => 'CMS Course',
                'tg' => 'CMS Course TG',
                'en' => 'CMS Course EN',
            ],
            'description' => [
                'ru' => 'Course description',
                'tg' => 'Course description TG',
                'en' => 'Course description EN',
            ],
            'duration' => '12 weeks',
            'hours' => 12,
            'price' => 100,
            'image' => UploadedFile::fake()->image('course.jpg'),
        ])
        ->assertRedirect(route('admin.courses.index'));

    expect(Course::query()->where('slug', 'cms-course')->exists())->toBeTrue();
});

it('admin can create a course from legacy flat course fields', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.courses.store'), [
            'title' => 'Legacy Flat Course',
            'description' => 'Legacy flat course description',
            'duration' => '8 weeks',
            'hours' => 24,
            'price' => 50,
        ])
        ->assertRedirect(route('admin.courses.index'));

    $course = Course::query()->where('slug', 'legacy-flat-course')->firstOrFail();

    expect($course->getTranslation('title', 'ru'))->toBe('Legacy Flat Course')
        ->and($course->getTranslation('description', 'ru'))->toBe('Legacy flat course description');
});

it('admin can create news from legacy flat news fields', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.news.store'), [
            'title' => 'Render News',
            'text' => 'Render news body',
            'is_published' => 1,
            'published_at' => '',
            'image' => UploadedFile::fake()->image('news.jpg'),
        ])
        ->assertRedirect(route('admin.news.index'));

    $newsPost = NewsPost::query()->where('slug', 'render-news')->firstOrFail();

    expect($newsPost->getTranslation('title', 'ru'))->toBe('Render News')
        ->and($newsPost->getTranslation('content', 'ru'))->toBe('Render news body')
        ->and($newsPost->is_published)->toBeTrue()
        ->and($newsPost->published_at)->not->toBeNull()
        ->and($newsPost->image_url)->not->toBeNull();

    $this->get('/ru/news/list')
        ->assertOk()
        ->assertSee('Render News');
});

it('admin can create gallery entries without an explicit category', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.gallery.store'), [
            'title' => 'Render Gallery',
            'description' => 'Gallery from Render payload',
            'image_path' => UploadedFile::fake()->image('gallery.jpg'),
        ])
        ->assertRedirect(route('admin.gallery.index'));

    $photo = Gallery::query()->where('slug', 'render-gallery')->firstOrFail();

    expect($photo->category)->toBe('general')
        ->and($photo->image_url)->not->toBeNull();

    $this->get('/ru/gallery')
        ->assertOk()
        ->assertSee('Render Gallery');
});

it('admin can create schedules from common schedule aliases', function (): void {
    $admin = User::factory()->admin()->create();
    $course = Course::factory()->create();

    $this->actingAs($admin)
        ->post(route('admin.schedules.store'), [
            'course_id' => $course->id,
            'starts_at' => now()->addWeek()->format('Y-m-d H:i:s'),
            'instructor' => 'Render Teacher',
            'description' => 'Render schedule description',
        ])
        ->assertRedirect(route('admin.schedules.index'));

    $schedule = Schedule::query()->where('course_id', $course->id)->firstOrFail();

    expect($schedule->teacher)->toBe('Render Teacher')
        ->and($schedule->schedule_text)->toBe('Render schedule description')
        ->and($schedule->start_date)->not->toBeNull();
});
