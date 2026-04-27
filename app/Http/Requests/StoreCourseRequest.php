<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\BuildsLocalizedRules;
use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    use BuildsLocalizedRules;

    public function authorize(): bool
    {
        return $this->user()?->can('create', Course::class) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'duration' => ['required', 'string', 'max:255'],
            'hours' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            ...$this->localizedFieldRules('title', ['string', 'max:255'], true, true),
            ...$this->localizedFieldRules('description', ['string']),
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->normalizeLegacyLocalizedField('title');
        $this->normalizeLegacyLocalizedField('description');
    }

    private function normalizeLegacyLocalizedField(string $field): void
    {
        $value = $this->input($field);

        if (is_array($value)) {
            return;
        }

        if (! is_string($value) || trim($value) === '') {
            return;
        }

        $this->merge([
            $field => [
                config('app.fallback_locale', 'ru') => trim($value),
            ],
        ]);
    }
}
