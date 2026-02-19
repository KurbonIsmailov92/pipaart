<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsService
{
    public function send(string $message): bool
    {
        if (! config('services.sms.enabled')) {
            return false;
        }

        $url = (string) config('services.sms.url');
        $recipient = (string) config('services.sms.to');

        if ($url === '' || $recipient === '') {
            return false;
        }

        $payload = [
            'to' => $recipient,
            'message' => $message,
            'sender' => (string) config('services.sms.sender'),
        ];

        if ($token = config('services.sms.token')) {
            $payload['token'] = $token;
        }

        return Http::asForm()
            ->timeout((int) config('services.sms.timeout', 5))
            ->post($url, $payload)
            ->successful();
    }
}
