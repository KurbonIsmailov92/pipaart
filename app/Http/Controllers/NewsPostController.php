<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsPostController extends Controller {
    public function index(Request $request): View|Factory|Application {
        $query = NewsPost::query();
        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('text', 'like', "%{$search}%");
        }
        $newsPosts = $query->orderByDesc('id')->paginate(10);
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
        return redirect()->route('news.list')->with('success', __('Новость успешно добавлена!'));
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

        return redirect()->route('news.list')->with('success', __('Новость обновлена.'));

    }

    public function destroy($id): RedirectResponse {
        $resource = NewsPost::findOrFail($id);
        $resource->delete();

        return redirect()->route('news.list')->with('success', __('Новость удалена.'));
    }
}
