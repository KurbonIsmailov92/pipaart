<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HasFilledTranslation implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_array($value)) {
            return;
        }

        foreach ($value as $translation) {
            if (filled(trim((string) $translation))) {
                return;
            }
        }

        $fail(__('validation.required', ['attribute' => str_replace('_', ' ', $attribute)]));
    }
}
