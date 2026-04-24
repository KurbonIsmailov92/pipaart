<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\NewsPost;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class NewsPostController extends Controller
{
    public function index(Request $request): View|Factory|Application
    {
        $newsPosts = NewsPost::query()
            ->published()
            ->search($request->string('search')->value())
            ->ordered()
            ->paginate(9)
            ->withQueryString();

        return view('public.news.index', [
            'newsPosts' => $newsPosts,
        ]);
    }

    public function show(string $locale, NewsPost $newsPost): View|Factory|Application
    {
        $this->authorize('view', $newsPost);

        return view('public.news.show', [
            'newsPost' => $newsPost,
        ]);
    }
}
