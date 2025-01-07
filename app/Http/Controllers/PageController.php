<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function homepage(): View
    {
        return view('pages.home');
    }
}
