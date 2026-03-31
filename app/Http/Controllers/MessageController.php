<?php

namespace App\Http\Controllers;

use App\Services\SmsService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function create(): View|Factory|Application
    {
        return view('contacts.message');
    }

    public function store(Request $request, SmsService $smsService): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $recipient = (string) config('services.contact.recipient', 'info@pipaa.tj');

        $mailBody = "Имя: {$validated['name']}\n"
            . "Email: {$validated['email']}\n"
            . "Телефон: " . ($validated['phone'] ?: '-') . "\n\n"
            . "Сообщение:\n{$validated['message']}";

        Mail::raw($mailBody, static function ($message) use ($recipient, $validated): void {
            $message->to($recipient)
                ->replyTo($validated['email'], $validated['name'])
                ->subject('Новое сообщение с сайта PIPAA');
        });

        $smsText = sprintf(
            'PIPAA: %s (%s) отправил(а) сообщение. Проверьте почту %s.',
            $validated['name'],
            $validated['phone'] ?: $validated['email'],
            $recipient
        );

        $smsSent = $smsService->send($smsText);

        return back()->with(
            'success',
            $smsSent
                ? 'Сообщение отправлено на email и SMS уведомление доставлено.'
                : 'Сообщение отправлено на email. SMS уведомление не отправлено (проверьте настройки).'
        );
    }
}
