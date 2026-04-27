<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_enrollments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('active')->index();
            $table->date('started_at')->nullable();
            $table->date('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
        });

        Schema::create('course_schedules', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->dateTime('starts_at')->index();
            $table->dateTime('ends_at')->nullable();
            $table->string('location')->nullable();
            $table->string('teacher')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('certificates', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->nullable()->constrained()->nullOnDelete();
            $table->string('certificate_number')->nullable()->index();
            $table->string('title');
            $table->date('issued_at')->nullable()->index();
            $table->string('file_path')->nullable();
            $table->string('status')->default('issued')->index();
            $table->timestamps();
        });

        Schema::create('exam_dates', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->dateTime('exam_date')->index();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_dates');
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('course_schedules');
        Schema::dropIfExists('course_enrollments');
    }
};
