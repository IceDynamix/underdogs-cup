<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $discord = Socialite::driver('discord')->user();
        $user = User::updateOrCreate(['id' => $discord->getId()], [
            'name' => $discord->getName(),
            'avatar' => $discord->getAvatar()
        ]);

        Auth::login($user, true);
        return redirect('/');
    }
}
