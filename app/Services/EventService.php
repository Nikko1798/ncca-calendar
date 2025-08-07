<?php

namespace App\Services;
use App\Models\SocialToken;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Collection;
use Carbon\Carbon;
class EventService
{
    function storeEventsFromGoogleCalendar(){
        $token=SocialToken::where('user_id', 1)->first();

        //cache remember only stores the response in cache if it doesn't already exist.
        $events = Cache::remember("calendar_events_{$token->created_at}_{$token->id}_{$token->id}", now()->addMinutes(10), function () use ($token) {
   
            $response = Http::withToken(($token->access_token))
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
            $start = $event['start']['dateTime'] ?? null;
            $end = $event['end']['dateTime'] ?? null;
            return [
                'attendees' => $event['attendees'] ?? null,
                'start' => $start
                    ? Carbon::parse($start)->timezone('Asia/Singapore')->format('D M d Y H:i:s \G\M\TP T')
                    : 'No Start Date',
                'end' => $end
                    ? Carbon::parse($end)->timezone('Asia/Singapore')->format('D M d Y H:i:s \G\M\TP T')
                    : 'No End Date',
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

        // $events=self::refreshGoogleCalendarToken($token);
      
        // // return $mappedEvents;
        // if ($response->unauthorized()) {
        //     return $mappedEvents;
        // }
        // else{

        //     $events = $response->json();
        //     return $events;
        // }
        
    }

     function refreshGoogleCalendarToken($token){
         $refreshResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'refresh_token' => ($token->refresh_token),
                'grant_type' => 'refresh_token',
            ]);

            if ($refreshResponse->successful()) {
                $newAccessToken = $refreshResponse['access_token'];

                // Save the new token
                $token->access_token = ($newAccessToken);
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
