<?php

namespace App\Services;

use App\Models\Schedule;

class ScheduleService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Schedule
    {
        return Schedule::query()->create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Schedule $schedule, array $data): Schedule
    {
        $schedule->update($data);

        return $schedule->refresh();
    }

    public function delete(Schedule $schedule): void
    {
        $schedule->delete();
    }
}
