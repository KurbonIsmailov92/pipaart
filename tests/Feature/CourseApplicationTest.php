<?php

use App\Models\Course;
use App\Models\CourseApplication;
use App\Models\CourseEnrollment;
use App\Models\User;
use Illuminate\Database\QueryException;

it('shows the localized apply button for student users', function (): void {
    $user = User::factory()->student()->create();
    $course = Course::factory()->create();

    $this->actingAs($user)
        ->get(route('courses.show', ['locale' => 'ru', 'course' => $course]))
        ->assertOk()
        ->assertSee('Записаться на курс');
});

it('lets a student apply for a course once', function (): void {
    $user = User::factory()->student()->create();
    $course = Course::factory()->create();
    $payload = ['comment' => 'I want to join this course.'];

    $this->actingAs($user)
        ->post(route('courses.applications.store', ['locale' => 'ru', 'course' => $course]), $payload)
        ->assertRedirect(route('cabinet.applications', ['locale' => 'ru']));

    $this->actingAs($user)
        ->post(route('courses.applications.store', ['locale' => 'ru', 'course' => $course]), $payload)
        ->assertRedirect(route('cabinet.applications', ['locale' => 'ru']));

    expect(CourseApplication::query()
        ->where('user_id', $user->id)
        ->where('course_id', $course->id)
        ->count())->toBe(1);
});

it('blocks non student users from applying for courses', function (): void {
    $teacher = User::factory()->teacher()->create();
    $course = Course::factory()->create();

    $this->actingAs($teacher)
        ->post(route('courses.applications.store', ['locale' => 'ru', 'course' => $course]), [
            'comment' => 'Teacher should not apply as a student.',
        ])
        ->assertForbidden();
});

it('enforces one active application per student and course at database level', function (): void {
    $user = User::factory()->student()->create();
    $course = Course::factory()->create();

    CourseApplication::query()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => CourseApplication::STATUS_PENDING,
    ]);

    expect(fn () => CourseApplication::query()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => CourseApplication::STATUS_APPROVED,
    ]))->toThrow(QueryException::class);
});

it('shows login prompt to guests on course detail pages', function (): void {
    $course = Course::factory()->create();

    $this->get(route('courses.show', ['locale' => 'ru', 'course' => $course]))
        ->assertOk()
        ->assertSee(__('ui.applications.login_prompt'));
});

it('lets students see their own applications in cabinet', function (): void {
    $user = User::factory()->student()->create();
    $otherUser = User::factory()->student()->create();
    $course = Course::factory()->create();
    CourseApplication::query()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => CourseApplication::STATUS_PENDING,
        'admin_comment' => 'We will review your request.',
    ]);
    CourseApplication::query()->create([
        'user_id' => $otherUser->id,
        'course_id' => $course->id,
        'status' => CourseApplication::STATUS_REJECTED,
        'admin_comment' => 'Hidden from other students.',
    ]);

    $this->actingAs($user)
        ->get(route('cabinet.applications', ['locale' => 'ru']))
        ->assertOk()
        ->assertSee('В ожидании')
        ->assertSee('We will review your request.')
        ->assertDontSee('Hidden from other students.');
});

it('allows teachers to approve applications and creates course enrollment', function (): void {
    $teacher = User::factory()->teacher()->create();
    $student = User::factory()->student()->create();
    $course = Course::factory()->create();
    $application = CourseApplication::query()->create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'status' => CourseApplication::STATUS_PENDING,
    ]);

    $this->actingAs($teacher)
        ->patch(route('admin.course-applications.approve', $application), [
            'admin_comment' => 'Welcome to the course.',
        ])
        ->assertRedirect(route('admin.course-applications.show', $application));

    $application->refresh();

    expect($application->status)->toBe(CourseApplication::STATUS_APPROVED)
        ->and($application->reviewed_by)->toBe($teacher->id)
        ->and($application->admin_comment)->toBe('Welcome to the course.')
        ->and(CourseEnrollment::query()
            ->where('user_id', $student->id)
            ->where('course_id', $course->id)
            ->where('status', CourseEnrollment::STATUS_ACTIVE)
            ->exists())->toBeTrue();
});

it('allows teachers to reject applications with an admin comment', function (): void {
    $teacher = User::factory()->teacher()->create();
    $student = User::factory()->student()->create();
    $course = Course::factory()->create();
    $application = CourseApplication::query()->create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'status' => CourseApplication::STATUS_PENDING,
    ]);

    $this->actingAs($teacher)
        ->patch(route('admin.course-applications.reject', $application), [
            'admin_comment' => 'Please contact us for a later group.',
        ])
        ->assertRedirect(route('admin.course-applications.show', $application));

    expect($application->fresh()->status)->toBe(CourseApplication::STATUS_REJECTED)
        ->and($application->fresh()->admin_comment)->toBe('Please contact us for a later group.');
});
