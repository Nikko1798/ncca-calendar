<?php

namespace App\Services;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

use Google\Client as GoogleClient;
use Google\Service\Calendar;

use App\Models\User;
use App\Models\SocialToken;
class SocialiteService
{
    function socialiteAuth($provider) {
        
        $socialUser = Socialite::driver($provider)->stateless()->user();
       
        if(User::where('email', $socialUser->email)->exists())
        {
            $user=User::where('email', $socialUser->email)->first();
            $token=self::addToken($user, $socialUser);
            Auth::login($user);
        }
        else{
            $socailiteLoggedInUser=self::registerGoogleUser($socialUser);
            self::addToken($socailiteLoggedInUser, $socialUser);
            Auth::login($socailiteLoggedInUser);
        }

        
        return response()->json($token);
        // // $accessToken = $socialUser->token;

        // Fetch user's Google Calendar events
        // $response = Http::withToken($accessToken)->get('https://www.googleapis.com/calendar/v3/calendars/primary/events');

        // $events = $response->json();

    }
    function registerGoogleUser($socialUser){
        $user=User::create([
            'email'=>$socialUser->email,
            'name'=>$socialUser->name,
            'provider_user_id'=>$socialUser->id,
            'provider'=>'google',
            'password' => Hash::make(Str::random(40)),
        ]);
        return $user;
    }
    function addToken($user, $socialUser){
        $user->token()->delete();
        $token=SocialToken::create([
            'user_id'=>$user->id,
            'access_token'=>Crypt::encrypt($socialUser->token),
            'refresh_token'=>Crypt::encrypt($socialUser->refreshToken),
        ]);
        return $token;
    }
}
