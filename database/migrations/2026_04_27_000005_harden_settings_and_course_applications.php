<?php

use App\Models\CourseApplication;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table): void {
            if (! Schema::hasColumn('settings', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }

            if (! Schema::hasColumn('settings', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });

        if (Schema::hasColumn('settings', 'created_at') && Schema::hasColumn('settings', 'updated_at')) {
            DB::table('settings')
                ->whereNull('created_at')
                ->update([
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
        }

        Schema::table('course_applications', function (Blueprint $table): void {
            if (! Schema::hasColumn('course_applications', 'active_application_key')) {
                $table->string('active_application_key')->nullable()->after('course_id');
                $table->unique('active_application_key', 'course_applications_active_application_key_unique');
            }
        });

        if (Schema::hasColumn('course_applications', 'active_application_key')) {
            $seen = [];

            DB::table('course_applications')
                ->whereIn('status', CourseApplication::activeStatuses())
                ->orderBy('id')
                ->select(['id', 'user_id', 'course_id'])
                ->get()
                ->each(function (object $application) use (&$seen): void {
                    $key = $application->user_id.':'.$application->course_id;

                    if (isset($seen[$key])) {
                        return;
                    }

                    $seen[$key] = true;

                    DB::table('course_applications')
                        ->where('id', $application->id)
                        ->update(['active_application_key' => $key]);
                });
        }

        DB::table('users')
            ->whereIn('role', ['Admin', 'ADMIN'])
            ->update(['role' => 'admin']);

        DB::table('users')
            ->whereIn('role', ['Teacher', 'TEACHER'])
            ->update(['role' => 'teacher']);

        DB::table('users')
            ->whereIn('role', ['Student', 'STUDENT', 'Reader', 'READER', 'Guest', 'GUEST'])
            ->update(['role' => 'student']);
    }

    public function down(): void
    {
        Schema::table('course_applications', function (Blueprint $table): void {
            if (Schema::hasColumn('course_applications', 'active_application_key')) {
                $table->dropUnique('course_applications_active_application_key_unique');
                $table->dropColumn('active_application_key');
            }
        });

        Schema::table('settings', function (Blueprint $table): void {
            if (Schema::hasColumn('settings', 'created_at')) {
                $table->dropColumn('created_at');
            }

            if (Schema::hasColumn('settings', 'updated_at')) {
                $table->dropColumn('updated_at');
            }
        });
    }
};
