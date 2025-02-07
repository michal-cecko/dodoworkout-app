<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;

class PageController extends Controller
{
    public function homepage(): View
    {
        $events = Event::with(['media'])->orderBy("start_at", "asc")->get();
        return view('pages.home', ['events' => $events]);
    }

    public function postsArchive(): View
    {
        return view('pages.blog');
    }

    public function eventsArchive(): View
    {
        return view('pages.events');
    }

    public function post(string $slug): View
    {
        $post = Post::whereRaw("slug->> ? = ?", [App::currentLocale(), $slug])
            ->with(['media', 'tags'])
            ->published()
            ->firstOrFail();

        // Get related posts by shared tags
        $relatedPosts = Post::whereHas('tags', function ($query) use ($post) {
            $query->whereIn('tags.id', $post->tags->pluck('id'));
        })
            ->where('id', '!=', $post->id) // Exclude the current post
            ->published()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Fallback: If no related posts, get posts without tags
        if ($relatedPosts->isEmpty()) {
            $relatedPosts = Post::doesntHave('tags')
                ->where('id', '!=', $post->id)
                ->published()
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        return view('pages.article', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ]);
    }


    public function event(string $slug): View
    {
        $event = Event::whereRaw("slug->> ? = ?", [App::currentLocale(), $slug])
            ->with(['media', 'category'])
            ->published()
            ->firstOrFail();

        $relatedEvents = Event::where('category_id', $event->category_id)
            ->where('id', '!=', $event->id) // Exclude the current event
            ->where('start_at', '>=', now())
            ->orderBy('start_at', 'asc')
            ->limit(5)
            ->get();

        if ($relatedEvents->isEmpty()) {
            $relatedEvents = Event::whereNull('category_id')
                ->where('id', '!=', $event->id)
                ->where('start_at', '>=', now())
                ->orderBy('start_at', 'asc')
                ->limit(5)
                ->get();
        }

        return view('pages.event', ['event' => $event, 'relatedEvents' => $relatedEvents]);
    }
}
