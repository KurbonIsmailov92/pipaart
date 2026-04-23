<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Models\Course;
use App\Models\NewsPost;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class SearchController extends Controller
{
    public function __invoke(SearchRequest $request): View|Factory|Application
    {
        $query = $request->string('q')->trim()->value();

        return view('public.news.result', [
            'query' => $query,
            'newsPosts' => NewsPost::query()->published()->search($query)->ordered()->paginate(10),
            'courses' => Course::query()->search($query)->ordered()->take(6)->get(),
        ]);
    }
}
