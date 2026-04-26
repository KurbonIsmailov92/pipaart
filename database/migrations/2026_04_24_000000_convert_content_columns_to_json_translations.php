<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach ($this->translationColumns() as $table => $columns) {
            $this->convertColumnsToJson($table, $columns);
        }
    }

    public function down(): void
    {
        foreach ($this->translationColumns() as $table => $columns) {
            $this->convertColumnsToText($table, $columns);
        }
    }

    /**
     * @return array<string, array<string, array{type: string, index?: string}>>
     */
    private function translationColumns(): array
    {
        return [
            'courses' => [
                'title' => [
                    'type' => 'string',
                    'index' => 'courses_title_index',
                ],
                'description' => [
                    'type' => 'text',
                ],
            ],
            'news_posts' => [
                'title' => [
                    'type' => 'string',
                    'index' => 'news_posts_title_index',
                ],
                'content' => [
                    'type' => 'longText',
                ],
                'text' => [
                    'type' => 'longText',
                ],
            ],
            'pages' => [
                'title' => [
                    'type' => 'string',
                ],
                'content' => [
                    'type' => 'longText',
                ],
                'meta_title' => [
                    'type' => 'string',
                ],
                'meta_description' => [
                    'type' => 'text',
                ],
            ],
        ];
    }

    /**
     * @param  array<string, array{type: string, index?: string}>  $columns
     */
    private function convertColumnsToJson(string $table, array $columns): void
    {
        if (! Schema::hasTable($table)) {
            return;
        }

        foreach ($columns as $column => $definition) {
            if (! Schema::hasColumn($table, $column)) {
                continue;
            }

            if ($this->usesSqlite()) {
                $this->backfillJsonIntoExistingColumn($table, $column);

                continue;
            }

            $temporaryColumn = $column.'_translations';

            if (! Schema::hasColumn($table, $temporaryColumn)) {
                Schema::table($table, function (Blueprint $blueprint) use ($temporaryColumn): void {
                    $blueprint->json($temporaryColumn)->nullable();
                });
            }

            $this->backfillJsonIntoTemporaryColumn($table, $column, $temporaryColumn);
            $this->dropIndexIfExists($table, $definition['index'] ?? null);

            Schema::table($table, function (Blueprint $blueprint) use ($column): void {
                $blueprint->dropColumn($column);
            });

            Schema::table($table, function (Blueprint $blueprint) use ($temporaryColumn, $column): void {
                $blueprint->renameColumn($temporaryColumn, $column);
            });
        }
    }

    /**
     * @param  array<string, array{type: string, index?: string}>  $columns
     */
    private function convertColumnsToText(string $table, array $columns): void
    {
        if (! Schema::hasTable($table)) {
            return;
        }

        foreach ($columns as $column => $definition) {
            if (! Schema::hasColumn($table, $column)) {
                continue;
            }

            if ($this->usesSqlite()) {
                $this->backfillTextIntoExistingColumn($table, $column);

                continue;
            }

            $temporaryColumn = $column.'_text';

            if (! Schema::hasColumn($table, $temporaryColumn)) {
                $this->addTextColumn($table, $temporaryColumn, $definition['type']);
            }

            $this->backfillTextIntoTemporaryColumn($table, $column, $temporaryColumn);

            Schema::table($table, function (Blueprint $blueprint) use ($column): void {
                $blueprint->dropColumn($column);
            });

            Schema::table($table, function (Blueprint $blueprint) use ($temporaryColumn, $column): void {
                $blueprint->renameColumn($temporaryColumn, $column);
            });

            $this->addIndexIfMissing($table, $definition['index'] ?? null, $column);
        }
    }

    private function addTextColumn(string $table, string $column, string $type): void
    {
        Schema::table($table, function (Blueprint $blueprint) use ($column, $type): void {
            switch ($type) {
                case 'string':
                    $blueprint->string($column)->nullable();
                    break;

                case 'text':
                    $blueprint->text($column)->nullable();
                    break;

                default:
                    $blueprint->longText($column)->nullable();
                    break;
            }
        });
    }

    private function backfillJsonIntoExistingColumn(string $table, string $column): void
    {
        DB::table($table)
            ->select(['id', $column])
            ->orderBy('id')
            ->get()
            ->each(function (object $record) use ($table, $column): void {
                $translations = $this->normalizeTranslationsValue($record->{$column});

                if ($translations === null) {
                    return;
                }

                DB::table($table)
                    ->where('id', $record->id)
                    ->update([
                        $column => $this->encodeJson($translations),
                    ]);
            });
    }

    private function backfillJsonIntoTemporaryColumn(string $table, string $sourceColumn, string $targetColumn): void
    {
        DB::table($table)
            ->select(['id', $sourceColumn])
            ->orderBy('id')
            ->get()
            ->each(function (object $record) use ($table, $sourceColumn, $targetColumn): void {
                $translations = $this->normalizeTranslationsValue($record->{$sourceColumn});

                if ($translations === null) {
                    return;
                }

                DB::table($table)
                    ->where('id', $record->id)
                    ->update([
                        $targetColumn => $this->encodeJson($translations),
                    ]);
            });
    }

    private function backfillTextIntoExistingColumn(string $table, string $column): void
    {
        DB::table($table)
            ->select(['id', $column])
            ->orderBy('id')
            ->get()
            ->each(function (object $record) use ($table, $column): void {
                $value = $this->resolveTextValue($record->{$column});

                if ($value === null) {
                    return;
                }

                DB::table($table)
                    ->where('id', $record->id)
                    ->update([
                        $column => $value,
                    ]);
            });
    }

    private function backfillTextIntoTemporaryColumn(string $table, string $sourceColumn, string $targetColumn): void
    {
        DB::table($table)
            ->select(['id', $sourceColumn])
            ->orderBy('id')
            ->get()
            ->each(function (object $record) use ($table, $sourceColumn, $targetColumn): void {
                $value = $this->resolveTextValue($record->{$sourceColumn});

                if ($value === null) {
                    return;
                }

                DB::table($table)
                    ->where('id', $record->id)
                    ->update([
                        $targetColumn => $value,
                    ]);
            });
    }

    /**
     * @return array<string, string>|null
     */
    private function normalizeTranslationsValue(mixed $value): ?array
    {
        if ($value === null) {
            return null;
        }

        if (is_array($value)) {
            return $this->normalizeTranslationArray($value);
        }

        $stringValue = trim((string) $value);

        if ($stringValue === '') {
            return null;
        }

        $decoded = json_decode($stringValue, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $this->normalizeTranslationArray($decoded);
        }

        return $this->replicateAcrossLocales($stringValue);
    }

    private function resolveTextValue(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_array($value)) {
            return $this->preferredTranslation($value);
        }

        $stringValue = trim((string) $value);

        if ($stringValue === '') {
            return null;
        }

        $decoded = json_decode($stringValue, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $this->preferredTranslation($decoded);
        }

        return $stringValue;
    }

    /**
     * @param  array<string, mixed>  $translations
     * @return array<string, string>|null
     */
    private function normalizeTranslationArray(array $translations): ?array
    {
        $normalized = [];

        foreach (config('app.supported_locales', ['ru', 'tg', 'en']) as $locale) {
            $translation = trim((string) ($translations[$locale] ?? ''));

            if ($translation !== '') {
                $normalized[$locale] = $translation;
            }
        }

        if ($normalized !== []) {
            return $normalized;
        }

        $fallbackValue = $this->preferredTranslation($translations);

        return $fallbackValue === null
            ? null
            : $this->replicateAcrossLocales($fallbackValue);
    }

    /**
     * @param  array<string, mixed>  $translations
     */
    private function preferredTranslation(array $translations): ?string
    {
        $preferredLocales = array_unique([
            config('app.fallback_locale', 'ru'),
            'ru',
            'tg',
            'en',
        ]);

        foreach ($preferredLocales as $locale) {
            $translation = trim((string) ($translations[$locale] ?? ''));

            if ($translation !== '') {
                return $translation;
            }
        }

        foreach ($translations as $translation) {
            $normalizedTranslation = trim((string) $translation);

            if ($normalizedTranslation !== '') {
                return $normalizedTranslation;
            }
        }

        return null;
    }

    /**
     * @return array<string, string>
     */
    private function replicateAcrossLocales(string $value): array
    {
        $translations = [];

        foreach (config('app.supported_locales', ['ru', 'tg', 'en']) as $locale) {
            $translations[$locale] = $value;
        }

        return $translations;
    }

    private function encodeJson(array $translations): string
    {
        return json_encode($translations, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{}';
    }

    private function dropIndexIfExists(string $table, ?string $index): void
    {
        if ($index === null || ! Schema::hasIndex($table, $index)) {
            return;
        }

        Schema::table($table, function (Blueprint $blueprint) use ($index): void {
            $blueprint->dropIndex($index);
        });
    }

    private function addIndexIfMissing(string $table, ?string $index, string $column): void
    {
        if ($index === null || Schema::hasIndex($table, $index)) {
            return;
        }

        Schema::table($table, function (Blueprint $blueprint) use ($index, $column): void {
            $blueprint->index($column, $index);
        });
    }

    private function usesSqlite(): bool
    {
        return DB::getDriverName() === 'sqlite';
    }
};
