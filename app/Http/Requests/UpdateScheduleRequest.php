<?php

namespace App\Http\Requests;

use App\Models\Schedule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $payload = [];

        if (! $this->has('start_date') && $this->has('starts_at')) {
            $payload['start_date'] = $this->input('starts_at');
        }

        if (! $this->has('teacher') && $this->has('instructor')) {
            $payload['teacher'] = $this->input('instructor');
        }

        if (! $this->has('schedule_text')) {
            $payload['schedule_text'] = $this->input('description', $this->input('title'));
        }

        if ($payload !== []) {
            $this->merge($payload);
        }
    }

    public function authorize(): bool
    {
        $schedule = $this->route('schedule');

        return $schedule instanceof Schedule
            ? ($this->user()?->can('update', $schedule) ?? false)
            : false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'course_id' => ['required', 'exists:courses,id'],
            'start_date' => ['required', 'date'],
            'teacher' => ['required', 'string', 'max:255'],
            'schedule_text' => ['required', 'string'],
        ];
    }
}
