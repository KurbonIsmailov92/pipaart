<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class PageController extends Controller {
    public function __invoke() {
        return view('index');
    }

    public function index() {
        $newsPosts = NewsPost::query()
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        $oldNewsPosts = NewsPost::query()
            ->orderByDesc('id')
            ->skip(3)
            ->take(4)
            ->get();

        return view('index', compact('newsPosts', 'oldNewsPosts'));
    }
}
