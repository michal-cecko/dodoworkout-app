<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function homepage(): View
    {
        return view('pages.home');
    }

    public function blogArchive(): View
    {
        return view('pages.blog');
    }

    public function article(string $slug): View
    {
        return view('pages.article');
    }

    public function workshopsArchive(): View
    {
        return view('pages.workshops');
    }

    public function workshop(string $slug): View
    {
        return view('pages.workshop');
    }
}
