<?php

namespace App\Services;

use Google_Client;
use Google_Service_Calendar;

class GoogleCalendarService
{
    public function client()
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/client_secret.json'));
        $client->setRedirectUri('http://localhost:8080/ncca-calendar/auth/google/callback');
        $client->addScope(Google_Service_Calendar::CALENDAR_READONLY);
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        return $client;
    }

    public function getAuthUrl()
    {
        return $this->client()->createAuthUrl();
    }

    public function fetchToken($code)
    {
        $client = $this->client();
        $token = $client->fetchAccessTokenWithAuthCode($code);
        return $token;
    }

    public function getEvents($token)
    {
        $client = $this->client();
        $client->setAccessToken($token);

        $service = new Google_Service_Calendar($client);

        $events = $service->events->listEvents('primary', [
            'maxResults' => 10,
            'orderBy' => 'startTime',
            'singleEvents' => true,
        ]);

        return $events->getItems();
    }

}
