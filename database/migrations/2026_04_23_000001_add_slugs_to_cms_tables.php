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
            $table->string('slug')->nullable()->after('title');
            $table->unique('slug');
        });

        Schema::table('news_posts', function (Blueprint $table): void {
            $table->string('slug')->nullable()->after('title');
            $table->unique('slug');
        });

        Schema::table('galleries', function (Blueprint $table): void {
            $table->string('slug')->nullable()->after('title');
            $table->unique('slug');
        });

        $this->backfillTable('courses');
        $this->backfillTable('news_posts');
        $this->backfillTable('galleries');
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table): void {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });

        Schema::table('news_posts', function (Blueprint $table): void {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });

        Schema::table('galleries', function (Blueprint $table): void {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }

    private function backfillTable(string $table): void
    {
        DB::table($table)
            ->select(['id', 'title'])
            ->orderBy('id')
            ->get()
            ->each(function (object $record) use ($table): void {
                $baseSlug = Str::slug((string) $record->title);
                $slug = $baseSlug !== '' ? $baseSlug : 'item-'.$record->id;
                $suffix = 1;

                while (DB::table($table)->where('slug', $slug)->where('id', '!=', $record->id)->exists()) {
                    $slug = $baseSlug.'-'.$suffix;
                    $suffix++;
                }

                DB::table($table)
                    ->where('id', $record->id)
                    ->update(['slug' => $slug]);
            });
    }
};
