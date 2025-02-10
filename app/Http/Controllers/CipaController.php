<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class CipaController extends Controller
{
    public function index(): View|Factory|Application {
        return view('cipa.index');
    }

    public function schedule(): View|Factory|Application
    {
        return view('cipa.schedule');
    }

    public function registration(): View|Factory|Application
    {
        return view('cipa.registration');
    }

    public function appeal(): View|Factory|Application
    {
        return view('cipa.appeal');
    }

    public function rules(): View|Factory|Application
    {
     return view('cipa.rules');
    }

    public function id(): View|Factory|Application
    {
        return view('cipa.id');
    }

    public function certification(): View|Factory|Application
    {
        return view('cipa.certification');
    }

    public function certificates(): View|Factory|Application
    {
        return view('cipa.certificates');
    }

}
