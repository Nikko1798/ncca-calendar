<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Video;

Route::get('/', function () {
    $vids=Video::select('floor')->distinct()->get();
    return Inertia::render('Welcome', [
        'videos' => $vids
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/schedules.php';
require __DIR__.'/events.php';
require __DIR__.'/video.php';
