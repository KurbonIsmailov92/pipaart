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
            $table->string('meta_description')->nullable();
            $table->boolean('is_published')->default(true)->index();
            $table->timestamps();
        });

        DB::table('pages')->insert([
            [
                'slug' => 'about',
                'title' => 'About',
                'content' => 'This page introduces the institute, mission, and educational direction.',
                'meta_title' => 'About PIPAA',
                'meta_description' => 'About the Public Institute of Professional Accountants and Auditors.',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'certifications',
                'title' => 'Certifications',
                'content' => 'Certification details for CAP and CIPA can be managed from the CMS.',
                'meta_title' => 'CAP / CIPA Certifications',
                'meta_description' => 'Certification pathways and exam information.',
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
