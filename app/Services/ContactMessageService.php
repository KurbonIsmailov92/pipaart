<?php

namespace App\Services;

use App\Jobs\SendContactMessageJob;
use App\Models\ContactMessage;

class ContactMessageService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function createAndQueue(array $data): ContactMessage
    {
        $message = ContactMessage::query()->create($data);

        SendContactMessageJob::dispatch($message->getKey());

        return $message;
    }
}
