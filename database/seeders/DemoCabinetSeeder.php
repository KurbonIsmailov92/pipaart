<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CourseSchedule;
use App\Models\ExamDate;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoCabinetSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::query()->first();

        if (! $course) {
            return;
        }

        $user = User::query()->updateOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Demo Student',
                'password' => Hash::make('password'),
                'role' => UserRole::Student->value,
                'email_verified_at' => now(),
            ],
        );

        CourseEnrollment::query()->updateOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $course->id,
            ],
            [
                'status' => CourseEnrollment::STATUS_ACTIVE,
                'started_at' => now()->toDateString(),
                'completed_at' => null,
            ],
        );

        CourseSchedule::query()->updateOrCreate(
            [
                'course_id' => $course->id,
                'title' => 'Demo lesson',
            ],
            [
                'starts_at' => now()->addWeek(),
                'ends_at' => now()->addWeek()->addHours(2),
                'location' => 'PIPAA Training Center',
                'teacher' => 'Demo Teacher',
                'description' => 'Sample lesson for the student cabinet.',
            ],
        );

        Certificate::query()->updateOrCreate(
            ['certificate_number' => 'PIPAA-DEMO-001'],
            [
                'user_id' => $user->id,
                'course_id' => $course->id,
                'title' => 'Demo Certificate',
                'issued_at' => now()->subMonth()->toDateString(),
                'status' => Certificate::STATUS_ISSUED,
            ],
        );

        ExamDate::query()->updateOrCreate(
            [
                'course_id' => $course->id,
                'title' => 'Demo exam',
            ],
            [
                'user_id' => $user->id,
                'exam_date' => now()->addWeeks(3),
                'location' => 'PIPAA Exam Room',
                'description' => 'Sample exam date for the student cabinet.',
            ],
        );
    }
}
