<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

class GalleryController extends Controller
{
    public function index()
    {
        $photos = Gallery::latest()->paginate(12);
        return view('gallery.index', compact('photos'));
    }

    public function create()
    {
        $this->authorize('adminOnly');
        return view('gallery.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('adminOnly');
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imageName = uniqid('gallery_', true) . '.' . $request->image->extension();
        $request->image->storeAs('gallery', $imageName, 'public');
        $data['image'] = $imageName;
        Gallery::create($data);
        return redirect()->route('gallery.index')->with('success', 'Фото успешно добавлено!');
    }

    public function show(Gallery $gallery)
    {
        return view('gallery.show', ['photo' => $gallery]);
    }

    public function edit(Gallery $gallery)
    {
        $this->authorize('adminOnly');
        return view('gallery.edit', ['photo' => $gallery]);
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $this->authorize('adminOnly');
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
            if ($gallery->image && Storage::disk('public')->exists('gallery/'.$gallery->image)) {
                Storage::disk('public')->delete('gallery/'.$gallery->image);
            }
            $imageName = uniqid('gallery_', true) . '.' . $request->image->extension();
            $request->image->storeAs('gallery', $imageName, 'public');
            $data['image'] = $imageName;
        }
        $gallery->update($data);
        return redirect()->route('gallery.index')->with('success', 'Фото обновлено!');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        $this->authorize('adminOnly');
        if ($gallery->image && Storage::disk('public')->exists('gallery/'.$gallery->image)) {
            Storage::disk('public')->delete('gallery/'.$gallery->image);
        }
        $gallery->delete();
        return redirect()->route('gallery.index')->with('success', 'Фото удалено.');
    }
}
