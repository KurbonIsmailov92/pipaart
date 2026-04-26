<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsPostRequest;
use App\Http\Requests\UpdateNewsPostRequest;
use App\Models\NewsPost;
use App\Services\NewsService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class AdminNewsPostController extends Controller
{
    public function __construct(
        protected NewsService $newsService,
    ) {}

    public function index(): View|Factory|Application
    {
        $this->authorize('viewAny', NewsPost::class);

        return view('admin.news.index', [
            'newsPosts' => NewsPost::query()->ordered()->paginate(10),
        ]);
    }

    public function create(): View|Factory|Application
    {
        $this->authorize('create', NewsPost::class);

        return view('admin.news.create', [
            'newsPost' => new NewsPost,
        ]);
    }

    public function store(StoreNewsPostRequest $request): RedirectResponse
    {
        $this->newsService->create($request->validated());

        return redirect()->route('admin.news.index')->with('success', __('ui.flash.news_created'));
    }

    public function edit(NewsPost $news): View|Factory|Application
    {
        $this->authorize('update', $news);

        return view('admin.news.edit', [
            'newsPost' => $news,
        ]);
    }

    public function update(UpdateNewsPostRequest $request, NewsPost $news): RedirectResponse
    {
        $this->newsService->update($news, $request->validated());

        return redirect()->route('admin.news.index')->with('success', __('ui.flash.news_updated'));
    }

    public function destroy(NewsPost $news): RedirectResponse
    {
        $this->authorize('delete', $news);

        $this->newsService->delete($news);

        return redirect()->route('admin.news.index')->with('success', __('ui.flash.news_deleted'));
    }
}
