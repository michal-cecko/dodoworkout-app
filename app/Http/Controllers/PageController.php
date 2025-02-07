<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Post;
use Illuminate\Config\Repository;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;

class PageController extends Controller
{
    public function homepage(): View
    {
        $events = Event::latest()->with(['media'])->limit(5)->get();
        return view('pages.home', ['events' => $events]);
    }

    public function postsArchive(): View
    {
        return view('pages.blog');
    }

    public function eventsArchive(): View
    {
        return view('pages.workshops');
    }
    public function post(string $slug): View
    {
        $post = Post::whereRaw("slug->> ? = ?", [App::currentLocale(), $slug])
            ->with(['media', 'tags'])
            ->published()
            ->firstOrFail();

        return view('pages.article', ['post' => $post]);
    }

    public function event(string $slug): View
    {
        $event = Event::whereRaw("slug->> ? = ?", [App::currentLocale(), $slug])
            ->with(['media', 'category'])
            ->published()
            ->firstOrFail();

        return view('pages.workshop', ['event' => $event]);
    }
}
