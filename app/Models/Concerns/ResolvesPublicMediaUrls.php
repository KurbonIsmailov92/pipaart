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

        if (Str::startsWith($normalizedPath, ['http://', 'https://', '/'])) {
            return $normalizedPath;
        }

        $normalizedPath = preg_replace('#^(?:storage/app/public/|public/|storage/)+#', '', ltrim($normalizedPath, '/'));
        $normalizedPath = preg_replace('#/+#', '/', (string) $normalizedPath);

        if ($normalizedPath === '') {
            return null;
        }

        return Storage::disk('public')->url($normalizedPath);
    }
}
