<?php

use App\Http\Controllers\EventsController;
use Inertia\Inertia;

use Illuminate\Support\Facades\Route;
use App\Services\GoogleCalendarService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use App\Models\SocialToken;


Route::get('/google/auth', function (GoogleCalendarService $calendar) {
    return response()->json([
        'authUrl' => $calendar->getAuthUrl()
    ]);
})->name('google.auth');

Route::get('/auth/google/callback', function (GoogleCalendarService $calendar) {
    $token = $calendar->fetchToken(request('code'));
    $socilaToken=SocialToken::updateOrCreate(
    ['user_id' => Auth::user()->id],
    [
        'user_id'=>Auth::user()->id,
        'access_token'=>$token['access_token'] ?? null,
        'refresh_token'=>$token['refresh_token'] ?? null,
    ]);
    return redirect()->route('dashboard');
    
});

Route::prefix('events')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('{floor}', [EventsController::class, 'index'])->name('events.index');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/CalendarView', [EventsController::class, 'CalendarView'])->name('events.CalendarView');
        });

    
});

Route::prefix('calendar-events')->group(function () {
      Route::get('/all', [EventsController::class, 'getEvents'])->name('calendar-events.all');
  
});

// 