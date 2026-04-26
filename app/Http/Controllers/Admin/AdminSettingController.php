<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class AdminSettingController extends Controller
{
    public function __construct(
        protected SettingsService $settingsService,
    ) {}

    public function index(): View|Factory|Application
    {
        $this->authorize('viewAny', Setting::class);

        return view('admin.settings.index', [
            'settings' => $this->settingsService->all(),
        ]);
    }

    public function update(UpdateSettingRequest $request): RedirectResponse
    {
        $this->authorize('update', Setting::class);

        /** @var array<string, string|null> $payload */
        $payload = $request->validated('settings');

        $this->settingsService->updateMany($payload);

        return redirect()->route('admin.settings.index')->with('success', __('ui.flash.settings_updated'));
    }
}
