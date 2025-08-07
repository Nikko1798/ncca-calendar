<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;
use App\Services\SocialiteService;
class SocialiteController extends Controller
{
    //
    protected $socserv;
    public function __construct(SocialiteService $socserv)
    {
        $this->socserv=$socserv;
    }
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)
        ->scopes([
        'openid',
        'profile',
        'email',
        'https://www.googleapis.com/auth/calendar.readonly', // calendar read access
        'https://www.googleapis.com/auth/tasks.readonly'  //task api read access
        ])
        ->with([
            'access_type' => 'offline', // 🔑 needed for refresh token
            'prompt' => 'consent'       // 🔁 forces Google to return a refresh token every time
        ])
        ->redirect();
        // return Socialite::driver('google')->stateless()->rediKrect();

    }
    public function handleProviderCallback($provider)
    {
        try {
            return $this->socserv->socialiteAuth($provider);
        } catch (\Exception $e) {
            return redirect()->route('login')->with(['error' => 'Unable to login using ' . $provider]);
        }
    }
}
