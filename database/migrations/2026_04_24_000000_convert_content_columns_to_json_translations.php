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
            foreach ($columns as $column => $definition) {
                $this->ensureJsonTranslationColumn($table, $column, $definition);
            }
        }
    }

    public function down(): void
    {
        foreach ($this->translationColumns() as $table => $columns) {
            foreach ($columns as $column => $definition) {
                $this->syncLegacyTextBackup($table, $column, $definition);
            }
        }
    }

    /**
     * @return array<string, array<string, array{legacy: string, type: string, index?: string}>>
     */
    private function translationColumns(): array
    {
        return [
            'courses' => [
                'title' => [
                    'legacy' => 'title_legacy',
                    'type' => 'string',
                    'index' => 'courses_title_index',
                ],
                'description' => [
                    'legacy' => 'description_legacy',
                    'type' => 'longText',
                ],
            ],
            'news_posts' => [
                'title' => [
                    'legacy' => 'title_legacy',
                    'type' => 'string',
                    'index' => 'news_posts_title_index',
                ],
                'content' => [
                    'legacy' => 'content_legacy',
                    'type' => 'longText',
                ],
                'text' => [
                    'legacy' => 'text_legacy',
                    'type' => 'longText',
                ],
            ],
            'pages' => [
                'title' => [
                    'legacy' => 'title_legacy',
                    'type' => 'string',
                ],
                'content' => [
                    'legacy' => 'content_legacy',
                    'type' => 'longText',
                ],
                'meta_title' => [
                    'legacy' => 'meta_title_legacy',
                    'type' => 'string',
                ],
                'meta_description' => [
                    'legacy' => 'meta_description_legacy',
                    'type' => 'longText',
                ],
            ],
        ];
    }

    /**
     * @param  array{legacy: string, type: string, index?: string}  $definition
     */
    private function ensureJsonTranslationColumn(string $table, string $column, array $definition): void
    {
        if (! Schema::hasTable($table)) {
            return;
        }

        $legacyColumn = $definition['legacy'];
        $hasCurrentColumn = Schema::hasColumn($table, $column);
        $hasLegacyColumn = Schema::hasColumn($table, $legacyColumn);

        if ($hasCurrentColumn && ! $hasLegacyColumn) {
            $this->dropIndexIfExists($table, $definition['index'] ?? null);

            Schema::table($table, function (Blueprint $blueprint) use ($column, $legacyColumn): void {
                $blueprint->renameColumn($column, $legacyColumn);
            });

            $this->makeColumnNullable($table, $legacyColumn, $definition['type']);

            $hasCurrentColumn = false;
            $hasLegacyColumn = true;
        }

        if (! $hasCurrentColumn) {
            Schema::table($table, function (Blueprint $blueprint) use ($column): void {
                $blueprint->json($column)->nullable();
            });
        }

        $sourceColumn = Schema::hasColumn($table, $legacyColumn) ? $legacyColumn : $column;

        $this->backfillJsonTranslationColumn($table, $sourceColumn, $column);
    }

    private function makeColumnNullable(string $table, string $column, string $type): void
    {
        Schema::table($table, function (Blueprint $blueprint) use ($column, $type): void {
            match ($type) {
                'string' => $blueprint->string($column)->nullable()->change(),
                'text' => $blueprint->text($column)->nullable()->change(),
                default => $blueprint->longText($column)->nullable()->change(),
            };
        });
    }

    /**
     * @param  array{legacy: string, type: string, index?: string}  $definition
     */
    private function syncLegacyTextBackup(string $table, string $column, array $definition): void
    {
        if (! Schema::hasTable($table) || ! Schema::hasColumn($table, $column)) {
            return;
        }

        $legacyColumn = $definition['legacy'];

        if (! Schema::hasColumn($table, $legacyColumn)) {
            $this->addLegacyColumn($table, $legacyColumn, $definition['type']);
        }

        DB::table($table)
            ->select(['id', $column])
            ->orderBy('id')
            ->get()
            ->each(function (object $record) use ($table, $column, $legacyColumn): void {
                $value = $this->resolveTextValue($record->{$column});

                if ($value === null) {
                    return;
                }

                DB::table($table)
                    ->where('id', $record->id)
                    ->update([
                        $legacyColumn => $value,
                    ]);
            });
    }

    private function addLegacyColumn(string $table, string $column, string $type): void
    {
        Schema::table($table, function (Blueprint $blueprint) use ($column, $type): void {
            match ($type) {
                'string' => $blueprint->string($column)->nullable(),
                'text' => $blueprint->text($column)->nullable(),
                default => $blueprint->longText($column)->nullable(),
            };
        });
    }

    private function backfillJsonTranslationColumn(string $table, string $sourceColumn, string $targetColumn): void
    {
        $columns = array_values(array_unique(['id', $sourceColumn, $targetColumn]));

        DB::table($table)
            ->select($columns)
            ->orderBy('id')
            ->get()
            ->each(function (object $record) use ($table, $sourceColumn, $targetColumn): void {
                $currentTranslations = $this->normalizeTranslationsValue($record->{$targetColumn} ?? null);

                if ($currentTranslations !== null) {
                    return;
                }

                $translations = $this->normalizeTranslationsValue($record->{$sourceColumn} ?? null);

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

        $fallbackValue = $this->resolveTextValue($translations);

        return $fallbackValue === null
            ? null
            : $this->replicateAcrossLocales($fallbackValue);
    }

    private function resolveTextValue(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_array($value)) {
            return $this->resolvePreferredTranslation($value);
        }

        $stringValue = trim((string) $value);

        if ($stringValue === '') {
            return null;
        }

        $decoded = json_decode($stringValue, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $this->resolvePreferredTranslation($decoded);
        }

        return $stringValue;
    }

    /**
     * @param  array<string, mixed>  $translations
     */
    private function resolvePreferredTranslation(array $translations): ?string
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
};
