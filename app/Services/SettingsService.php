<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Schema;

class SettingsService
{
    /**
     * @return Collection<int, Setting>
     */
    public function all(): Collection
    {
        if (! Schema::hasTable('settings')) {
            return new Collection();
        }

        return Setting::query()->orderBy('key')->get();
    }

    /**
     * @param  array<string, string>  $defaults
     * @return array<string, string>
     */
    public function getPublicSettings(array $defaults = []): array
    {
        if (! Schema::hasTable('settings')) {
            return $defaults;
        }

        return array_replace(
            $defaults,
            Setting::query()->pluck('value', 'key')->all(),
        );
    }

    /**
     * @param  array<string, string|null>  $settings
     */
    public function updateMany(array $settings): void
    {
        foreach ($settings as $key => $value) {
            Setting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value],
            );
        }
    }
}
