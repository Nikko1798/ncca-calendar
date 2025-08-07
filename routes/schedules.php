<?php

use App\Http\Controllers\SchedulesController;
use Inertia\Inertia;

Route::middleware('auth')->prefix('my-schedules')->group(function () {
    Route::get('/', [SchedulesController::class, 'index'])->name('my-schedules.index');
    Route::post('/create', [SchedulesController::class, 'create'])->name('my-schedules.create');
    Route::get('/get', [SchedulesController::class, 'getSchedule'])->name('my-schedules.get');
    
});