<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Collection;
use Carbon\Carbon;
class ScheduleService
{
    function storeEventsFromGoogleCalendar(){
        $user=Auth::user();
        $token=$user->token;

        //cache remember only stores the response in cache if it doesn't already exist.
        $events = Cache::remember("calendar_events_{$user->created_at}_{$user->id}_{$user->id}", now()->addMinutes(10), function () use ($token, $user) {
   
            $response = Http::withToken(Crypt::decrypt($token->access_token))
            ->get('https://www.googleapis.com/calendar/v3/calendars/primary/events');

            if ($response->unauthorized()) {
                return self::refreshGoogleCalendarToken($token);
            }
            else{

                $events = $response->json();
                return $events;
            }
        });


        $mappedEvents = collect($events['items'])->map(function ($event) {
            return [
                'start' => Carbon::parse($event['start']['dateTime'])->timezone('Asia/Singapore')->format('D M d Y H:i:s \G\M\TP T') ,
                'end' => Carbon::parse($event['end']['dateTime'])->timezone('Asia/Singapore')->format('D M d Y H:i:s \G\M\TP T'),
                'title' => $event['summary'] ?? 'Untitled Event',
                'content' => '<i class="icon mdi mdi-stethoscope"></i>',
                'class' => 'healths',
                'style' => [
                    'backgroundColor' => 'rgb(198 246 213)',
                    'color' => '#065f46',
                ],
            ];
        });
        return $mappedEvents;
    }
    
    function refreshGoogleCalendarToken($token){
         $refreshResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'refresh_token' => Crypt::decrypt($token->refresh_token),
                'grant_type' => 'refresh_token',
            ]);

            if ($refreshResponse->successful()) {
                $newAccessToken = $refreshResponse['access_token'];

                // Save the new token
                $token->access_token = Crypt::encrypt($newAccessToken);
                $token->save();

                // Retry the original request with the new token
                $response = Http::withToken($newAccessToken)
                    ->get('https://www.googleapis.com/calendar/v3/calendars/primary/events');

                return $response->successful() ? $response->json() : null;
            } 
            else
            {
                return $refreshResponse;
            }
    }
}
