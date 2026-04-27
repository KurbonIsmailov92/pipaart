<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactMessageRequest;
use App\Services\ContactMessageService;
use App\Services\SettingsService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class MessageController extends Controller
{
    public function __construct(
        protected ContactMessageService $contactMessageService,
        protected SettingsService $settingsService,
    ) {}

    public function create(): View|Factory|Application
    {
        $defaults = [
            'contact_email' => 'info@pipaa.tj',
            'contact_backup_email' => '',
            'contact_phone' => '',
            'contact_address' => __('ui.contact.default_address'),
        ];

        return view('public.contacts.message', [
            'settings' => $this->settingsService->getPublicSettings($defaults),
        ]);
    }

    public function store(ContactMessageRequest $request): RedirectResponse
    {
        $this->contactMessageService->createAndQueue([
            ...$request->validated(),
            'locale' => $request->route('locale'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', __('ui.flash.contact_message_queued'));
    }
}
