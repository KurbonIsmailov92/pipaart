<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class ContactController extends Controller
{
    public function index(): View|Factory|Application
    {
        return view('contacts.info');
    }

    public function info(): View|Factory|Application
    {
        return view('contacts.info');
    }
}
