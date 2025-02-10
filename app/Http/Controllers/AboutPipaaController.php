<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class AboutPipaaController extends Controller
{
    public function index(): View|Factory|Application
    {
        return view('oipba.oipba');
    }

    public function work(): View|Factory|Application
    {
        return view('oipba.work');
    }

    public function membership(): View|Factory|Application
    {
        return view('oipba.membership');
    }

    public function partners(): View|Factory|Application
    {
        return view('oipba.partners');
    }

    public function customers(): View|Factory|Application
    {
        return view('oipba.customers');
    }

    public function collective(): View|Factory|Application
    {
        return view('oipba.collective');
    }

    public function gallery(): View|Factory|Application
    {
        return view('oipba.gallery');
    }
}
