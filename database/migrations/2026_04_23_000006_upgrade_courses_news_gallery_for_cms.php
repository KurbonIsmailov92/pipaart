<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table): void {
            $table->string('duration')->nullable()->after('description');
            $table->decimal('price', 10, 2)->nullable()->after('duration');
        });

        Schema::table('news_posts', function (Blueprint $table): void {
            $table->longText('content')->nullable()->after('text');
            $table->timestamp('published_at')->nullable()->after('image')->index();
        });

        Schema::table('galleries', function (Blueprint $table): void {
            $table->string('image_path')->nullable()->after('image');
            $table->string('category')->nullable()->after('title')->index();
        });

        DB::table('courses')->whereNull('duration')->update([
            'duration' => DB::raw('CAST(hours as varchar(255))'),
            'price' => 0,
        ]);

        DB::table('news_posts')->whereNull('content')->update([
            'content' => DB::raw('text'),
            'published_at' => now(),
        ]);

        DB::table('galleries')->whereNull('image_path')->update([
            'image_path' => DB::raw('image'),
            'category' => 'general',
        ]);
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table): void {
            $table->dropColumn(['duration', 'price']);
        });

        Schema::table('news_posts', function (Blueprint $table): void {
            $table->dropColumn(['content', 'published_at']);
        });

        Schema::table('galleries', function (Blueprint $table): void {
            $table->dropColumn(['image_path', 'category']);
        });
    }
};
