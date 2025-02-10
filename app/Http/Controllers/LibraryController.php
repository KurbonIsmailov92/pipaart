<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class LibraryController extends Controller {

    public function index(): View|Factory|Application {
        return view('library.index');
    }

    public function docs(): View|Factory|Application {
        return view('library.docs');
    }

    public function books(): View|Factory|Application {
        return view('library.books');
    }

    public function forCipa(): View|Factory|Application {
        return view('library.for-cipa');
    }

    public function links(): View|Factory|Application {
        return view('library.links');
    }

}
