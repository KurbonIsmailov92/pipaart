<?php

use App\Jobs\SendContactMessageJob;
use App\Models\ContactMessage;
use App\Services\SmsService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\Mailer\Exception\TransportException;

it('queues contact message delivery and stores the message', function (): void {
    $locale = 'ru';
    Queue::fake();

    $response = $this->post(route('contacts.message.store', ['locale' => $locale]), [
        'name' => 'Test User',
        'email' => 'user@example.com',
        'phone' => '+992111111111',
        'message' => 'Hello from test',
    ]);

    $response->assertSessionHas('success');

    expect(ContactMessage::query()->where('email', 'user@example.com')->exists())->toBeTrue();

    Queue::assertPushed(SendContactMessageJob::class);
});

it('validates required fields for contact message', function (): void {
    $response = $this->post(route('contacts.message.store', ['locale' => 'ru']), []);

    $response->assertSessionHasErrors(['name', 'email', 'message']);
});

it('does not crash contact message processing when mail transport is unavailable', function (): void {
    config(['services.sms.enabled' => false]);

    $message = ContactMessage::query()->create([
        'name' => 'Transport Test',
        'email' => 'transport@example.com',
        'phone' => null,
        'message' => 'SMTP is not configured yet.',
    ]);

    Mail::shouldReceive('to')
        ->once()
        ->andThrow(new TransportException('SMTP unavailable'));

    (new SendContactMessageJob($message->getKey()))->handle(app(SmsService::class));

    expect($message->fresh()->processed_at)->not->toBeNull();
});
