<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\BuildsLocalizedRules;
use App\Models\Page;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePageRequest extends FormRequest
{
    use BuildsLocalizedRules;

    public function authorize(): bool
    {
        $page = $this->route('page');

        return $page instanceof Page
            ? ($this->user()?->can('update', $page) ?? false)
            : false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var Page|null $page */
        $page = $this->route('page');

        return [
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('pages', 'slug')->ignore($page?->id)],
            'is_published' => ['nullable', 'boolean'],
            ...$this->localizedFieldRules('title', ['string', 'max:255']),
            ...$this->localizedFieldRules('content', ['string'], false),
            ...$this->localizedFieldRules('meta_title', ['string', 'max:255'], false),
            ...$this->localizedFieldRules('meta_description', ['string', 'max:255'], false),
        ];
    }
}
