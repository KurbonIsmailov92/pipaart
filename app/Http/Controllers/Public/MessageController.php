<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactMessageRequest;
use App\Services\ContactMessageService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class MessageController extends Controller
{
    public function __construct(
        protected ContactMessageService $contactMessageService,
    ) {
    }

    public function create(): View|Factory|Application
    {
        return view('public.contacts.message');
    }

    public function store(ContactMessageRequest $request): RedirectResponse
    {
        $this->contactMessageService->createAndQueue($request->validated());

        return back()->with('success', 'Your message has been received and queued for delivery.');
    }
}
