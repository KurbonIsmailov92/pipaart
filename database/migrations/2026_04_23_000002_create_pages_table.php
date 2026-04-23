<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table): void {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('is_published')->default(true)->index();
            $table->timestamps();
        });

        DB::table('pages')->insert([
            [
                'slug' => 'about',
                'title' => 'About PIPAA',
                'content' => 'Manage this page from the admin panel to describe the institute, its mission, and history.',
                'meta_title' => 'About PIPAA',
                'meta_description' => 'About the Public Institute of Professional Accountants and Auditors.',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'certifications',
                'title' => 'CAP / CIPA Certifications',
                'content' => 'Use this page to manage certification requirements, registration details, and useful information for CAP and CIPA students.',
                'meta_title' => 'CAP / CIPA Certifications',
                'meta_description' => 'CAP and CIPA certification information.',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
