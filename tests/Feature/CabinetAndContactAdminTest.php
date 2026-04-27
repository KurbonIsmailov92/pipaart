<?php

use App\Models\Certificate;
use App\Models\ContactMessage;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CourseSchedule;
use App\Models\ExamDate;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

it('stores contact messages with request metadata and shows them in admin', function (): void {
    $admin = User::factory()->admin()->create();

    $this->withServerVariables([
        'REMOTE_ADDR' => '203.0.113.10',
        'HTTP_USER_AGENT' => 'Feature Test Browser',
    ])->post(route('contacts.message.store', ['locale' => 'ru']), [
        'name' => 'Contact Sender',
        'email' => 'sender@example.com',
        'phone' => '+992000000000',
        'subject' => 'Course question',
        'message' => 'I want to know more about the course.',
    ])->assertSessionHas('success');

    $message = ContactMessage::query()->where('email', 'sender@example.com')->firstOrFail();

    expect($message->subject)->toBe('Course question')
        ->and($message->locale)->toBe('ru')
        ->and($message->user_agent)->toBe('Feature Test Browser')
        ->and($message->is_read)->toBeFalse();

    $this->actingAs($admin)
        ->get(route('admin.contact-messages.index'))
        ->assertOk()
        ->assertSee('Contact Sender')
        ->assertSee('Course question');

    $this->actingAs($admin)
        ->patch(route('admin.contact-messages.read', $message))
        ->assertSessionHas('success');

    expect($message->refresh()->is_read)->toBeTrue();
});

it('keeps admin contact messages private', function (): void {
    $this->get(route('admin.contact-messages.index'))
        ->assertRedirect(route('auth.login'));
});

it('renders cabinet pages for authenticated users only', function (): void {
    $user = User::factory()->student()->create();
    $course = Course::factory()->create([
        'title' => ['ru' => 'Cabinet course', 'tg' => 'Cabinet course', 'en' => 'Cabinet course'],
    ]);

    CourseEnrollment::query()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => CourseEnrollment::STATUS_ACTIVE,
        'started_at' => now()->toDateString(),
    ]);

    CourseSchedule::query()->create([
        'course_id' => $course->id,
        'title' => 'Cabinet lesson',
        'starts_at' => now()->addDay(),
    ]);

    Certificate::query()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'title' => 'Cabinet certificate',
        'status' => Certificate::STATUS_ISSUED,
    ]);

    ExamDate::query()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'title' => 'Cabinet exam',
        'exam_date' => now()->addWeek(),
    ]);

    $this->get('/ru/cabinet')->assertRedirect(route('auth.login'));

    $this->actingAs($user)->get('/ru/cabinet')->assertOk()->assertSee('1');
    $this->actingAs($user)->get('/ru/cabinet/courses')->assertOk()->assertSee('Cabinet course');
    $this->actingAs($user)->get('/ru/cabinet/schedule')->assertOk()->assertSee('Cabinet lesson');
    $this->actingAs($user)->get('/ru/cabinet/certificates')->assertOk()->assertSee('Cabinet certificate');
    $this->actingAs($user)->get('/ru/cabinet/exams')->assertOk()->assertSee('Cabinet exam');
});

it('protects certificate downloads', function (): void {
    Storage::fake('public');

    $owner = User::factory()->student()->create();
    $otherUser = User::factory()->student()->create();
    $admin = User::factory()->admin()->create();
    $course = Course::factory()->create();

    Storage::disk('public')->put('certificates/test.txt', 'certificate');

    $certificate = Certificate::query()->create([
        'user_id' => $owner->id,
        'course_id' => $course->id,
        'title' => 'Protected certificate',
        'file_path' => 'certificates/test.txt',
        'status' => Certificate::STATUS_ISSUED,
    ]);

    $url = route('cabinet.certificates.download', ['locale' => 'ru', 'certificate' => $certificate]);

    $this->actingAs($otherUser)->get($url)->assertForbidden();
    $this->actingAs($owner)->get($url)->assertOk();
    $this->actingAs($admin)->get($url)->assertOk();
});
