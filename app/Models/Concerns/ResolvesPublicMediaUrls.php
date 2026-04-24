<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ResolvesPublicMediaUrls
{
    protected function resolvePublicMediaUrl(?string $path): ?string
    {
        if (! is_string($path)) {
            return null;
        }

        $normalizedPath = trim(str_replace('\\', '/', $path));

        if ($normalizedPath === '') {
            return null;
        }

        if (Str::startsWith($normalizedPath, ['http://', 'https://'])) {
            return $normalizedPath;
        }

        $trimmedPath = ltrim($normalizedPath, '/');
        $normalizedManagedPath = preg_replace('#^(?:storage/app/public/|public/|storage/)+#', '', $trimmedPath);
        $normalizedManagedPath = preg_replace('#/+#', '/', (string) $normalizedManagedPath);

        $isManagedStoragePath = $normalizedManagedPath !== $trimmedPath
            || ! Str::startsWith($normalizedPath, '/');

        if (! $isManagedStoragePath) {
            return $normalizedPath;
        }

        $normalizedPath = trim((string) $normalizedManagedPath, '/');
        $normalizedPath = preg_replace('#/+#', '/', (string) $normalizedPath);

        if ($normalizedPath === '') {
            return null;
        }

        if (! Storage::disk('public')->exists($normalizedPath)) {
            return null;
        }

        $publicStoragePath = public_path('storage/'.str_replace('/', DIRECTORY_SEPARATOR, $normalizedPath));

        if (file_exists($publicStoragePath)) {
            return Storage::disk('public')->url($normalizedPath);
        }

        if (app()->bound('router') && app('router')->has('media.public')) {
            return route('media.public', ['path' => $normalizedPath]);
        }

        return Storage::disk('public')->url($normalizedPath);
    }
}
