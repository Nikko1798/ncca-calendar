<?php

use App\Http\Controllers\VideoController;

Route::middleware('auth')->prefix('videos-view')->group(function () {
    Route::get('/', [VideoController::class, 'index'])->name('videos-view.index');
    Route::post('/insert', [VideoController::class, 'insert'])->name('videos-view.insert');

});