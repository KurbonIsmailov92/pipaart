<h1>New contact message</h1>

<p><strong>Name:</strong> {{ $contactMessage->name }}</p>
<p><strong>Email:</strong> {{ $contactMessage->email }}</p>
<p><strong>Phone:</strong> {{ $contactMessage->phone ?: '-' }}</p>

<p><strong>Message:</strong></p>
<p>{!! nl2br(e($contactMessage->message)) !!}</p>
