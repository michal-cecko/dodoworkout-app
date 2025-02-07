<?php

use App\Http\Controllers\PageController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

//EN ROUTES

Route::group(['prefix' => "en", 'middleware' => [SetLocale::class]], function () {
    Route::get('/', [PageController::class, 'homepage'])->name('en.homepage');
    Route::get('/blog', [PageController::class, 'blog'])->name('en.blog');
    Route::get('/blog/{post}', [PageController::class, 'article'])->name('en.article');
    Route::get('/events', [PageController::class, 'events'])->name('en.events');
    Route::get('/events/{event}', [PageController::class, 'event'])->name('en.event');
});

//SK ROUTES

Route::get('/', [PageController::class, 'homepage'])->name('homepage');
Route::get('/blog', [PageController::class, 'postsArchive'])->name('blog');
Route::get('/blog/{post}', [PageController::class, 'post'])->name('article');
Route::get('/eventy', [PageController::class, 'eventsArchive'])->name('events');
Route::get('/eventy/{event}', [PageController::class, 'event'])->name('event');
