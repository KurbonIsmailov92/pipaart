<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\BuildsLocalizedRules;
use App\Models\NewsPost;
use Illuminate\Foundation\Http\FormRequest;

class StoreNewsPostRequest extends FormRequest
{
    use BuildsLocalizedRules;

    public function authorize(): bool
    {
        return $this->user()?->can('create', NewsPost::class) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'published_at' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            ...$this->localizedFieldRules('title', ['string', 'max:255']),
            ...$this->localizedFieldRules('content', ['string']),
        ];
    }
}
