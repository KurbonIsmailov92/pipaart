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
        $this->authorize('adminOnly', NewsPost::class);
        return view('news-post.create');
    }

    public function store(Request $request): RedirectResponse {
        $this->authorize('adminOnly', NewsPost::class);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $imageName = uniqid('news_', true) . '.' . $request->image->extension();
            $request->image->storeAs('news', $imageName, 'public');
            $validated['image'] = $imageName;
        }
        NewsPost::create($validated);
        return redirect()->route('news.list')->with('success', __('Новость успешно добавлена!'));
    }

    public function show($id): View|Factory|Application {
        $newsPost = NewsPost::findOrFail($id);
        return view('news-post.show', compact('newsPost'));
    }

    public function edit(NewsPost $newsPost): View|Factory|Application {
        $this->authorize('adminOnly', $newsPost);
        return view('news-post.edit', ['resource' => $newsPost]);
    }

    public function update(Request $request, NewsPost $newsPost): RedirectResponse {
        $this->authorize('adminOnly', $newsPost);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
            // удалить старый файл если был
            if ($newsPost->image && \Storage::disk('public')->exists('news/'.$newsPost->image)) {
                \Storage::disk('public')->delete('news/'.$newsPost->image);
            }
            $imageName = uniqid('news_', true) . '.' . $request->image->extension();
            $request->image->storeAs('news', $imageName, 'public');
            $validated['image'] = $imageName;
        }
        $newsPost->update($validated);
        return redirect()->route('news.list')->with('success', __('Новость обновлена.'));
    }

    public function destroy(NewsPost $newsPost): RedirectResponse {
        $this->authorize('adminOnly', $newsPost);
        $newsPost->delete();

        return redirect()->route('news.list')->with('success', __('Новость удалена.'));
    }
}
