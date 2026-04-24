<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;

class GalleryController extends Controller
{
    public function index(): View|Factory|Application
    {
        $photos = new LengthAwarePaginator([], 0, 12);

        try {
            $photos = Gallery::query()->ordered()->paginate(12);
        } catch (Throwable) {
            //
        }

        return view('public.gallery.index', [
            'photos' => $photos,
        ]);
    }

    public function show(Gallery $gallery): View|Factory|Application
    {
        return view('public.gallery.show', [
            'photo' => $gallery,
        ]);
    }
}
