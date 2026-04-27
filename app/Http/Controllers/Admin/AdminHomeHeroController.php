<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeHero;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminHomeHeroController extends Controller
{
    public function index(): View|Factory|Application
    {
        return view('admin.home-heroes.index', [
            'heroes' => HomeHero::query()->orderBy('locale')->get(),
        ]);
    }

    public function edit(HomeHero $homeHero): View|Factory|Application
    {
        return view('admin.home-heroes.edit', [
            'hero' => $homeHero,
        ]);
    }

    public function update(Request $request, HomeHero $homeHero): RedirectResponse
    {
        $data = $request->validate([
            'locale' => [
                'required',
                Rule::in(config('app.supported_locales', ['ru', 'tg', 'en'])),
                Rule::unique('home_heroes', 'locale')->ignore($homeHero->id),
            ],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:2000'],
            'cta_text' => ['nullable', 'string', 'max:100'],
            'cta_url' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $homeHero->update($data);

        return redirect()->route('admin.home-heroes.index')->with('success', __('ui.flash.home_hero_updated'));
    }
}
