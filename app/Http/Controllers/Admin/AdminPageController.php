<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;
use App\Services\PageService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class AdminPageController extends Controller
{
    public function __construct(
        protected PageService $pageService,
    ) {
    }

    public function index(): View|Factory|Application
    {
        $this->authorize('viewAny', Page::class);

        return view('admin.pages.index', [
            'pages' => Page::query()->ordered()->paginate(10),
        ]);
    }

    public function create(): View|Factory|Application
    {
        $this->authorize('create', Page::class);

        return view('admin.pages.create', [
            'page' => new Page(),
        ]);
    }

    public function store(StorePageRequest $request): RedirectResponse
    {
        $this->pageService->create([
            ...$request->validated(),
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page): View|Factory|Application
    {
        $this->authorize('update', $page);

        return view('admin.pages.edit', [
            'page' => $page,
        ]);
    }

    public function update(UpdatePageRequest $request, Page $page): RedirectResponse
    {
        $this->pageService->update($page, [
            ...$request->validated(),
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        $this->authorize('delete', $page);

        $this->pageService->delete($page);

        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully.');
    }
}
