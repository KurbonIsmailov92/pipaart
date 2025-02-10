<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsPostController extends Controller {
    public function index(): View|Factory|Application {
        $newsPosts = NewsPost::query()
            ->orderByDesc('id')
            ->get();
        return view('news-post.news', compact('newsPosts'));
    }

    public function create(): View|Factory|Application {
        return view('news-post.create');
    }

    public function store(Request $request): RedirectResponse {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
        ]);
        NewsPost::create($validated);
        return redirect()->route('news.list')->with('success', 'Новость успешно добавлена!');
    }

    public function show($id): View|Factory|Application {
        $newsPost = NewsPost::findOrFail($id);
        return view('news-post.show', compact('newsPost'));
    }

    public function edit($id): View|Factory|Application {
        $resource = NewsPost::findOrFail($id);
        return view('news-post.edit', compact('resource'));
    }

    public function update(Request $request, $id): RedirectResponse {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            ]);
        $resource = NewsPost::findOrFail($id);
        $resource->update($validated);

        return redirect()->route('news.list')->with('success', 'Новость обновлена.');

    }

    public function destroy($id): RedirectResponse {
        $resource = NewsPost::findOrFail($id);
        $resource->delete();

        return redirect()->route('news.list')->with('success', 'Новость удалена.');
    }
}
