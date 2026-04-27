<?php

namespace App\Http\Requests;

use App\Models\Gallery;
use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->hasFile('image') && ! $this->hasFile('image_path')) {
            $this->files->set('image_path', $this->file('image'));
        }

        if ($this->hasFile('photo') && ! $this->hasFile('image_path')) {
            $this->files->set('image_path', $this->file('photo'));
        }

        if (! $this->filled('category')) {
            $this->merge(['category' => 'general']);
        }
    }

    public function authorize(): bool
    {
        return $this->user()?->can('create', Gallery::class) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'image_path' => ['required_without_all:image,photo', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }
}
