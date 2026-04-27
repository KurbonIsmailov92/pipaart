<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeHero extends Model
{
    use HasFactory;

    protected $fillable = [
        'locale',
        'title',
        'subtitle',
        'cta_text',
        'cta_url',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function localizedCtaUrl(string $locale, string $fallback): string
    {
        $url = trim((string) $this->cta_url);

        if ($url === '') {
            return $fallback;
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://') || str_starts_with($url, '#')) {
            return $url;
        }

        $path = str_starts_with($url, '/') ? $url : '/'.$url;

        if ($path === '/'.$locale || str_starts_with($path, '/'.$locale.'/')) {
            return $path;
        }

        return '/'.$locale.$path;
    }
}
