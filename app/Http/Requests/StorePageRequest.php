<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\BuildsLocalizedRules;
use App\Models\Page;
use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
{
    use BuildsLocalizedRules;

    public function authorize(): bool
    {
        return $this->user()?->can('create', Page::class) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:pages,slug'],
            'is_published' => ['nullable', 'boolean'],
            ...$this->localizedFieldRules('title', ['string', 'max:255']),
            ...$this->localizedFieldRules('content', ['string'], false),
            ...$this->localizedFieldRules('meta_title', ['string', 'max:255'], false),
            ...$this->localizedFieldRules('meta_description', ['string', 'max:255'], false),
        ];
    }
}
