<?php

use App\Models\Course;
use App\Models\Page;
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
