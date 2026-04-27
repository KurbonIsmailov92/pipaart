<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table): void {
            if (! Schema::hasColumn('contact_messages', 'subject')) {
                $table->string('subject')->nullable()->after('phone');
            }

            if (! Schema::hasColumn('contact_messages', 'locale')) {
                $table->string('locale', 5)->nullable()->after('message')->index();
            }

            if (! Schema::hasColumn('contact_messages', 'ip_address')) {
                $table->string('ip_address', 45)->nullable()->after('locale');
            }

            if (! Schema::hasColumn('contact_messages', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('ip_address');
            }

            if (! Schema::hasColumn('contact_messages', 'is_read')) {
                $table->boolean('is_read')->default(false)->after('user_agent')->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table): void {
            foreach (['subject', 'locale', 'ip_address', 'user_agent', 'is_read'] as $column) {
                if (Schema::hasColumn('contact_messages', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
