<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login()
    {
        return Socialite::driver('discord')->scopes(['guilds'])->redirect();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function callback()
    {
        $discordUser = Socialite::driver('discord')->user();
        dd($discordUser);
    }
}
