<?php

use App\Http\Controllers\SchedulesController;
use Inertia\Inertia;

Route::middleware('auth')->prefix('my-schedules')->group(function () {
    Route::get('/', [SchedulesController::class, 'index'])->name('my-schedules.index');
});