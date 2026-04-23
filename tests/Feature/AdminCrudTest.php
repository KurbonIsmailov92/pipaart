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
            'title' => 'New Page',
            'content' => 'Page content',
            'meta_title' => 'Meta',
            'meta_description' => 'Meta description',
            'is_published' => 1,
        ])
        ->assertRedirect(route('admin.pages.index'));

    expect(Page::query()->where('slug', 'new-page')->exists())->toBeTrue();
});

it('admin can create a course', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.courses.store'), [
            'title' => 'CMS Course',
            'description' => 'Course description',
            'duration' => '12 weeks',
            'price' => 100,
            'image' => UploadedFile::fake()->image('course.jpg'),
        ])
        ->assertRedirect(route('admin.courses.index'));

    expect(Course::query()->where('title', 'CMS Course')->exists())->toBeTrue();
});
