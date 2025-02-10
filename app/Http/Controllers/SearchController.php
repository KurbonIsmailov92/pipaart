<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke()
    {
        $newsPosts = NewsPost::query()
            ->where('title', 'LIKE', '%'.request('q').'%')
            ->get();
        return view('news-post.result', ['newsPosts' => $newsPosts]);
    }

}
