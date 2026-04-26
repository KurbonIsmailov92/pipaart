<?php

use App\Jobs\SendContactMessageJob;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Queue;

it('queues contact message delivery and stores the message', function (): void {
    Queue::fake();
    $locale = 'ru';

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
