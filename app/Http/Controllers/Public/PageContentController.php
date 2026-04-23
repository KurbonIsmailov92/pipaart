<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\PageService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class PageContentController extends Controller
{
    public function __construct(
        protected PageService $pageService,
    ) {
    }

    public function show(string $slug): View|Factory|Application
    {
        abort_unless(in_array($slug, ['about', 'certifications'], true), 404);

        $page = $this->pageService->getPublishedPageBySlug($slug);

        abort_if($page === null, 404);

        return view('public.pages.show', [
            'page' => $page,
        ]);
    }
}
