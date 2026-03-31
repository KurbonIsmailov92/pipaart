<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

it('sends contact message email and sms notification when configured', function (): void {
    config()->set('services.contact.recipient', 'info@pipaa.tj');
    config()->set('services.sms.enabled', true);
    config()->set('services.sms.url', 'https://sms-gateway.local/send');
    config()->set('services.sms.to', '+992900000000');
    config()->set('services.sms.token', 'secret');

    Mail::fake();
    Http::fake([
        'https://sms-gateway.local/send' => Http::response(['ok' => true], 200),
    ]);

    $response = $this->post(route('contacts.message.store'), [
        'name' => 'Test User',
        'email' => 'user@example.com',
        'phone' => '+992111111111',
        'message' => 'Hello from test',
    ]);

    $response->assertSessionHas('success');

    Mail::assertSentCount(1);
    Http::assertSentCount(1);
});

it('validates required fields for contact message', function (): void {
    $response = $this->post(route('contacts.message.store'), []);

    $response->assertSessionHasErrors(['name', 'email', 'message']);
});
