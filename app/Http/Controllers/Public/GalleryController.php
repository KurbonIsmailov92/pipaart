<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Services\GalleryService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class GalleryController extends Controller
{
    public function index(GalleryService $galleryService): View|Factory|Application
    {
        return view('public.gallery.index', [
            'photos' => $galleryService->paginatePublic(),
        ]);
    }

    public function show(string $locale, Gallery $gallery): View|Factory|Application
    {
        return view('public.gallery.show', [
            'photo' => $gallery,
        ]);
    }
}
