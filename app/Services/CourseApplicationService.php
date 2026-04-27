<?php

namespace App\Services;

use App\Models\Course;
use App\Models\CourseApplication;
use App\Models\CourseEnrollment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CourseApplicationService
{
    public function apply(User $user, Course $course, ?string $comment = null): CourseApplication
    {
        $existingApplication = CourseApplication::query()
            ->where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->active()
            ->latest()
            ->first();

        if ($existingApplication !== null) {
            return $existingApplication;
        }

        return CourseApplication::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => CourseApplication::STATUS_PENDING,
            'comment' => $comment,
        ]);
    }

    public function approve(CourseApplication $application, User $reviewer, ?string $adminComment = null): CourseApplication
    {
        abort_unless($application->isPending(), 422);

        return DB::transaction(function () use ($application, $reviewer, $adminComment): CourseApplication {
            $application->forceFill([
                'status' => CourseApplication::STATUS_APPROVED,
                'admin_comment' => $adminComment,
                'reviewed_by' => $reviewer->id,
                'reviewed_at' => now(),
            ])->save();

            CourseEnrollment::query()->updateOrCreate(
                [
                    'user_id' => $application->user_id,
                    'course_id' => $application->course_id,
                ],
                [
                    'status' => CourseEnrollment::STATUS_ACTIVE,
                    'started_at' => now()->toDateString(),
                    'completed_at' => null,
                ],
            );

            return $application;
        });
    }

    public function reject(CourseApplication $application, User $reviewer, ?string $adminComment = null): CourseApplication
    {
        abort_unless($application->isPending(), 422);

        $application->forceFill([
            'status' => CourseApplication::STATUS_REJECTED,
            'admin_comment' => $adminComment,
            'reviewed_by' => $reviewer->id,
            'reviewed_at' => now(),
        ])->save();

        return $application;
    }
}
