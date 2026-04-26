<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class RootRedirectController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        return redirect('/ru');
    }
}
