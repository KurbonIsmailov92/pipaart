<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table): void {
            $table->string('slug')->nullable()->unique();
            $table->string('duration')->nullable();
            $table->decimal('price', 10, 2)->nullable()->default(0);
        });

        Schema::table('news_posts', function (Blueprint $table): void {
            $table->string('slug')->nullable()->unique();
            $table->longText('content')->nullable();
            $table->timestamp('published_at')->nullable()->index();
        });

        Schema::table('galleries', function (Blueprint $table): void {
            $table->string('slug')->nullable()->unique();
            $table->string('category')->nullable()->index();
            $table->string('image_path')->nullable();
        });

        $uniqueSlug = static function (string $table, string $title, int $id): string {
            $baseSlug = Str::slug($title);
            $baseSlug = $baseSlug !== '' ? $baseSlug : $table;
            $slug = $baseSlug;
            $suffix = 2;

            while (
                DB::table($table)
                    ->where('slug', $slug)
                    ->where('id', '!=', $id)
                    ->exists()
            ) {
                $slug = $baseSlug.'-'.$suffix;
                $suffix++;
            }

            return $slug;
        };

        foreach (DB::table('courses')->orderBy('id')->get() as $course) {
            DB::table('courses')
                ->where('id', $course->id)
                ->update([
                    'slug' => $uniqueSlug('courses', (string) $course->title, (int) $course->id),
                    'duration' => $course->duration ?: (($course->hours ?? null) ? $course->hours.' hours' : null),
                    'price' => $course->price ?? 0,
                ]);
        }

        foreach (DB::table('news_posts')->orderBy('id')->get() as $newsPost) {
            DB::table('news_posts')
                ->where('id', $newsPost->id)
                ->update([
                    'slug' => $uniqueSlug('news_posts', (string) $newsPost->title, (int) $newsPost->id),
                    'content' => $newsPost->content ?: $newsPost->text,
                    'published_at' => $newsPost->published_at ?: $newsPost->created_at,
                ]);
        }

        foreach (DB::table('galleries')->orderBy('id')->get() as $gallery) {
            DB::table('galleries')
                ->where('id', $gallery->id)
                ->update([
                    'slug' => $uniqueSlug('galleries', (string) $gallery->title, (int) $gallery->id),
                    'category' => $gallery->category ?: 'general',
                    'image_path' => $gallery->image_path ?: $gallery->image,
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table): void {
            $table->dropColumn(['slug', 'duration', 'price']);
        });

        Schema::table('news_posts', function (Blueprint $table): void {
            $table->dropColumn(['slug', 'content', 'published_at']);
        });

        Schema::table('galleries', function (Blueprint $table): void {
            $table->dropColumn(['slug', 'category', 'image_path']);
        });
    }
};
