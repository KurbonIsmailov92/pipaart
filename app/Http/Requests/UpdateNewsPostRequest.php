<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\BuildsLocalizedRules;
use App\Models\NewsPost;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsPostRequest extends FormRequest
{
    use BuildsLocalizedRules;

    public function authorize(): bool
    {
        $newsPost = $this->route('news');

        return $newsPost instanceof NewsPost
            ? ($this->user()?->can('update', $newsPost) ?? false)
            : false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'is_published' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            ...$this->localizedFieldRules('title', ['string', 'max:255'], true, true),
            ...$this->localizedFieldRules('content', ['string']),
        ];
    }
}
