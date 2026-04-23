<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class ContactController extends Controller
{
    public function __construct(
        protected SettingsService $settingsService,
    ) {
    }

    public function info(): View|Factory|Application
    {
        $defaults = [
            'contact_email' => 'info@pipaa.tj',
            'contact_backup_email' => '',
            'contact_phone' => '',
            'contact_address' => 'Dushanbe, Tajikistan',
        ];

        return view('public.contacts.info', [
            'settings' => $this->settingsService->getPublicSettings($defaults),
        ]);
    }
}
