<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'image',
        'image_path',
    ];

    protected static function booted(): void
    {
        static::saving(static function (Gallery $gallery): void {
            if (blank($gallery->image) && filled($gallery->image_path)) {
                $gallery->image = $gallery->image_path;
            }

            if (blank($gallery->image_path) && filled($gallery->image)) {
                $gallery->image_path = $gallery->image;
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->latest();
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ?: $this->image;
    }
}
