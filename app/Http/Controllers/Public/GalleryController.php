<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class GalleryController extends Controller
{
    public function index(): View|Factory|Application
    {
        return view('public.gallery.index', [
            'photos' => Gallery::query()->ordered()->paginate(12),
        ]);
    }

    public function show(Gallery $gallery): View|Factory|Application
    {
        return view('public.gallery.show', [
            'photo' => $gallery,
        ]);
    }
}
