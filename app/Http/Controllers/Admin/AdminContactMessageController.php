<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminContactMessageController extends Controller
{
    public function index(Request $request): View|Factory|Application
    {
        $search = $request->string('search')->value();

        $messages = ContactMessage::query()
            ->when($search !== '', static function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%')
                        ->orWhere('phone', 'like', '%'.$search.'%')
                        ->orWhere('subject', 'like', '%'.$search.'%')
                        ->orWhere('message', 'like', '%'.$search.'%');
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.contact-messages.index', [
            'messages' => $messages,
            'search' => $search,
        ]);
    }

    public function show(ContactMessage $contactMessage): View|Factory|Application
    {
        return view('admin.contact-messages.show', [
            'message' => $contactMessage,
        ]);
    }

    public function markRead(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->update(['is_read' => true]);

        return back()->with('success', __('ui.flash.contact_message_updated'));
    }

    public function markUnread(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->update(['is_read' => false]);

        return back()->with('success', __('ui.flash.contact_message_updated'));
    }

    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return redirect()
            ->route('admin.contact-messages.index')
            ->with('success', __('ui.flash.contact_message_deleted'));
    }
}
