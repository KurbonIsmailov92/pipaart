<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    public function storeImage(UploadedFile $file, string $directory): string
    {
        return $file->store($directory, 'public');
    }

    public function replaceImage(?string $currentPath, ?UploadedFile $file, string $directory): ?string
    {
        if ($file === null) {
            return $currentPath;
        }

        $this->delete($currentPath);

        return $this->storeImage($file, $directory);
    }

    public function delete(?string $path): void
    {
        if ($path !== null && $path !== '' && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
