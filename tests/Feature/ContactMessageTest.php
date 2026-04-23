<?php

use App\Jobs\SendContactMessageJob;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Queue;

it('queues contact message delivery and stores the message', function (): void {
    Queue::fake();

    $response = $this->post(route('contacts.message.store'), [
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
    $response = $this->post(route('contacts.message.store'), []);

    $response->assertSessionHasErrors(['name', 'email', 'message']);
});
