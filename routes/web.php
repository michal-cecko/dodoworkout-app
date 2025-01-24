<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'homepage'])->name('homepage');
Route::get('/blog', [PageController::class, 'blogArchive'])->name('blogArchive');
Route::get('/blog/{slug}', [PageController::class, 'article'])->name('article');
Route::get('/workshops', [PageController::class, 'workshopsArchive'])->name('workshopsArchive');
Route::get('/workshops/{slug}', [PageController::class, 'workshop'])->name('workshop');
