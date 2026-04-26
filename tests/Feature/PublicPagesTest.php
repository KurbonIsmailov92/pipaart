<?php

use App\Models\Course;
use App\Models\Gallery;
use App\Models\NewsPost;
use App\Models\Page;
use App\Models\Schedule;

it('renders the core public pages', function (): void {
    $locale = 'ru';

    Page::query()->firstOrCreate(
        ['slug' => 'about'],
        [
            'title' => ['ru' => 'About'],
            'content' => ['ru' => 'About content'],
            'meta_title' => ['ru' => 'About'],
            'meta_description' => ['ru' => 'About content'],
            'is_published' => true,
        ]
    );

    Page::query()->firstOrCreate(
        ['slug' => 'certifications'],
        [
            'title' => ['ru' => 'Certifications'],
            'content' => ['ru' => 'Certification content'],
            'meta_title' => ['ru' => 'Certifications'],
            'meta_description' => ['ru' => 'Certification content'],
            'is_published' => true,
        ]
    );

    $course = Course::factory()->create();
    $news = NewsPost::factory()->create();
    $gallery = Gallery::query()->create([
        'title' => 'Gallery item',
        'slug' => 'gallery-item',
        'category' => 'general',
        'description' => 'Item',
        'image' => 'gallery/demo.jpg',
        'image_path' => 'gallery/demo.jpg',
    ]);
    Schedule::query()->create([
        'course_id' => $course->id,
        'start_date' => now()->addWeek()->toDateString(),
        'teacher' => 'Teacher',
        'schedule_text' => 'Every Monday',
    ]);

    $this->get(route('home', ['locale' => $locale]))->assertOk();
    $this->get(route('about', ['locale' => $locale]))->assertOk();
    $this->get(route('certifications', ['locale' => $locale]))->assertOk();
    $this->get(route('courses.index', ['locale' => $locale]))->assertOk();
    $this->get(route('schedule.index', ['locale' => $locale]))->assertOk();
    $this->get(route('news.index', ['locale' => $locale]))->assertOk();
    $this->get(route('gallery.index', ['locale' => $locale]))->assertOk();
    $this->get(route('contact', ['locale' => $locale]))->assertOk();
    $this->get(route('courses.show', ['locale' => $locale, 'course' => $course]))->assertOk();
    $this->get(route('news.show', ['locale' => $locale, 'newsPost' => $news]))->assertOk();
    $this->get(route('gallery.show', ['locale' => $locale, 'gallery' => $gallery]))->assertOk();
});

it('keeps the localized home page available when public content tables are empty', function (): void {
    \App\Models\Schedule::query()->delete();
    \App\Models\NewsPost::query()->delete();
    \App\Models\Course::query()->delete();
    \App\Models\Page::query()->delete();

    $this->get('/ru')
        ->assertOk();
});
