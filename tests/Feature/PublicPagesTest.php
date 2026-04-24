<?php

use App\Models\Course;
use App\Models\Gallery;
use App\Models\NewsPost;
use App\Models\Page;
use App\Models\Schedule;

it('renders the core public pages', function (): void {
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

    $this->get(route('home'))->assertOk();
    $this->get(route('about'))->assertOk();
    $this->get(route('certifications'))->assertOk();
    $this->get(route('courses.index'))->assertOk();
    $this->get(route('schedule.index'))->assertOk();
    $this->get(route('news.index'))->assertOk();
    $this->get(route('gallery.index'))->assertOk();
    $this->get(route('contact'))->assertOk();
    $this->get(route('courses.show', $course))->assertOk();
    $this->get(route('news.show', $news))->assertOk();
    $this->get(route('gallery.show', $gallery))->assertOk();
});
