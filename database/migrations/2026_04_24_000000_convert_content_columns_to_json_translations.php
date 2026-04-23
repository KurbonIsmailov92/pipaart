<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->convertColumnsToJson('courses', ['title', 'description']);
        $this->convertColumnsToJson('news_posts', ['title', 'content', 'text']);
        $this->convertColumnsToJson('pages', ['title', 'content', 'meta_title', 'meta_description']);
    }

    public function down(): void
    {
        $this->convertColumnsToText('courses', ['title', 'description']);
        $this->convertColumnsToText('news_posts', ['title', 'content', 'text']);
        $this->convertColumnsToText('pages', ['title', 'content', 'meta_title', 'meta_description']);
    }

    /**
     * @param  list<string>  $columns
     */
    private function convertColumnsToJson(string $table, array $columns): void
    {
        if (! Schema::hasTable($table)) {
            return;
        }

        foreach ($columns as $column) {
            if (! Schema::hasColumn($table, $column)) {
                continue;
            }

            $temporaryColumn = $column.'_translations';

            Schema::table($table, function (Blueprint $blueprint) use ($temporaryColumn): void {
                $blueprint->json($temporaryColumn)->nullable();
            });

            DB::table($table)
                ->select(['id', $column])
                ->orderBy('id')
                ->get()
                ->each(function (object $record) use ($table, $column, $temporaryColumn): void {
                    $value = $record->{$column};

                    if ($value === null || $value === '') {
                        return;
                    }

                    $translations = [
                        'ru' => (string) $value,
                        'tg' => (string) $value,
                        'en' => (string) $value,
                    ];

                    DB::table($table)
                        ->where('id', $record->id)
                        ->update([
                            $temporaryColumn => json_encode($translations, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                        ]);
                });

            Schema::table($table, function (Blueprint $blueprint) use ($column): void {
                $blueprint->dropColumn($column);
            });

            Schema::table($table, function (Blueprint $blueprint) use ($temporaryColumn, $column): void {
                $blueprint->renameColumn($temporaryColumn, $column);
            });
        }
    }

    /**
     * @param  list<string>  $columns
     */
    private function convertColumnsToText(string $table, array $columns): void
    {
        if (! Schema::hasTable($table)) {
            return;
        }

        foreach ($columns as $column) {
            if (! Schema::hasColumn($table, $column)) {
                continue;
            }

            $temporaryColumn = $column.'_text';

            Schema::table($table, function (Blueprint $blueprint) use ($temporaryColumn, $column, $table): void {
                if ($table === 'pages' || in_array($column, ['description', 'content', 'text', 'meta_description'], true)) {
                    $blueprint->longText($temporaryColumn)->nullable();
                } else {
                    $blueprint->string($temporaryColumn)->nullable();
                }
            });

            DB::table($table)
                ->select(['id', $column])
                ->orderBy('id')
                ->get()
                ->each(function (object $record) use ($table, $column, $temporaryColumn): void {
                    $decoded = json_decode((string) $record->{$column}, true);

                    if (! is_array($decoded)) {
                        return;
                    }

                    $value = $decoded[config('app.fallback_locale', 'ru')]
                        ?? $decoded['en']
                        ?? $decoded['tg']
                        ?? reset($decoded)
                        ?? null;

                    DB::table($table)
                        ->where('id', $record->id)
                        ->update([$temporaryColumn => $value]);
                });

            Schema::table($table, function (Blueprint $blueprint) use ($column): void {
                $blueprint->dropColumn($column);
            });

            Schema::table($table, function (Blueprint $blueprint) use ($temporaryColumn, $column): void {
                $blueprint->renameColumn($temporaryColumn, $column);
            });
        }
    }
};
