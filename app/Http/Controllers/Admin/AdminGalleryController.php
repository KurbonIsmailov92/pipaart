<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Models\Gallery;
use App\Services\GalleryService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class AdminGalleryController extends Controller
{
    public function __construct(
        protected GalleryService $galleryService,
    ) {}

    public function index(): View|Factory|Application
    {
        $this->authorize('viewAny', Gallery::class);

        return view('admin.gallery.index', [
            'photos' => Gallery::query()->ordered()->paginate(12),
        ]);
    }

    public function create(): View|Factory|Application
    {
        $this->authorize('create', Gallery::class);

        return view('admin.gallery.create', [
            'photo' => new Gallery,
        ]);
    }

    public function store(StoreGalleryRequest $request): RedirectResponse
    {
        $this->galleryService->create($request->validated());

        return redirect()->route('admin.gallery.index')->with('success', __('ui.flash.gallery_created'));
    }

    public function edit(Gallery $gallery): View|Factory|Application
    {
        $this->authorize('update', $gallery);

        return view('admin.gallery.edit', [
            'photo' => $gallery,
        ]);
    }

    public function update(UpdateGalleryRequest $request, Gallery $gallery): RedirectResponse
    {
        $this->galleryService->update($gallery, $request->validated());

        return redirect()->route('admin.gallery.index')->with('success', __('ui.flash.gallery_updated'));
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        $this->authorize('delete', $gallery);

        $this->galleryService->delete($gallery);

        return redirect()->route('admin.gallery.index')->with('success', __('ui.flash.gallery_deleted'));
    }
}
