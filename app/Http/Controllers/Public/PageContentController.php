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
    ) {}

    public function about(): View|Factory|Application
    {
        return $this->renderPage('about');
    }

    public function certifications(): View|Factory|Application
    {
        return $this->renderPage('certifications');
    }

    protected function renderPage(string $slug): View|Factory|Application
    {
        $page = $this->pageService->getPublishedPageBySlug($slug);

        abort_if($page === null, 404);

        return view('public.pages.show', [
            'page' => $page,
        ]);
    }
}
