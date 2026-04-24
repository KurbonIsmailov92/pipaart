<?php

namespace App\Http\Requests;

use App\Models\Gallery;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGalleryRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->hasFile('image') && ! $this->hasFile('image_path')) {
            $this->files->set('image_path', $this->file('image'));
        }
    }

    public function authorize(): bool
    {
        $gallery = $this->route('gallery');

        return $gallery instanceof Gallery
            ? ($this->user()?->can('update', $gallery) ?? false)
            : false;
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
            'image_path' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }
}
