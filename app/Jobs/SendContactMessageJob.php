<?php

namespace App\Jobs;

use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendContactMessageJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public int $contactMessageId,
    ) {}

    public function handle(SmsService $smsService): void
    {
        $contactMessage = ContactMessage::query()->find($this->contactMessageId);

        if ($contactMessage === null) {
            return;
        }

        $recipient = (string) config('services.contact.recipient', 'info@pipaa.tj');

        Mail::to($recipient)->send(new ContactMessageMail($contactMessage));

        $smsService->send(sprintf(
            'PIPAA contact: %s (%s) submitted a message.',
            $contactMessage->name,
            $contactMessage->phone ?: $contactMessage->email,
        ));

        $contactMessage->forceFill([
            'processed_at' => now(),
        ])->save();
    }
}
