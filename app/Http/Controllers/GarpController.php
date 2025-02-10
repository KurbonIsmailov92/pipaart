<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;


class GarpController extends Controller
{
    public function index(): View|Factory|Application {
        return view('garp.index');
    }

    public function schedule(): View|Factory|Application
    {
        return view('garp.schedule');
    }

    public function registration(): View|Factory|Application
    {
        return view('garp.registration');
    }

    public function certification(): View|Factory|Application
    {
        return view('garp.certification');
    }

    public function topic(): View|Factory|Application
    {
        return view('garp.topic');
    }

}
