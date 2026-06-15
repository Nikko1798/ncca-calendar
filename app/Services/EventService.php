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
   function storeEventsFromGoogleCalendar()
    {
        $token = SocialToken::where('user_id', 1)->first();

        if (!$token) {
            abort(401, 'No Google token found.');
        }

        try {
            $events = Cache::remember(
                "calendar_events_user_{$token->user_id}",
                now()->addMinutes(1),
                function () use ($token) {

                    $response = Http::withToken($token->access_token)
                        ->get('https://www.googleapis.com/calendar/v3/calendars/primary/events');

                    if (!$response->successful()) {
                        // don't return Response here
                        return null;
                    }

                    return $response->json();
                }
            );

            if (!$events || !isset($events['items'])) {
                return collect([]);
            }

            return collect($events['items'])->map(function ($event) {
                $start = $event['start']['dateTime'] ?? null;
                $end = $event['end']['dateTime'] ?? null;

                return [
                    'attendees' => $event['attendees'] ?? [],
                    'start' => $start
                        ? Carbon::parse($start)->timezone('Asia/Singapore')->format('D M d Y H:i:s')
                        : 'No Start Date',
                    'end' => $end
                        ? Carbon::parse($end)->timezone('Asia/Singapore')->format('D M d Y H:i:s')
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
        } catch (\Exception $e) {
            report($e);
            return collect([]);
        }
    }

     function refreshGoogleCalendarToken($token){

        try{
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

                return $response->successful() ? 
                [
                    'success' => true,
                    'data' => $response->json(),
                ]
                : null;
            } 
            else
            {
                $error = $refreshResponse->json();

                // Example: { "error": "invalid_grant", "error_description": "Bad Request" }
                return response()->json([
                    'success' => false,
                    'error' => $error['error'] ?? 'unknown_error',
                    'description' => $error['error_description'] ?? 'No description provided'
                ], $refreshResponse->status());
            }
        }
        catch(Exception $e)
        {
            return 'nada';
        }
    }
}
