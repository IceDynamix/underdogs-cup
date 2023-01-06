<?php

namespace App\Http\Controllers;

use App\Models\TetrioUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
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
            'avatar' => $discord->getAvatar(),
        ]);

        Auth::login($user, true);

        return redirect('/');
    }

    public function login()
    {
        return Socialite::driver('discord')->scopes(['guilds'])->redirect();
    }

    public function viewConnect()
    {
        return view('connect');
    }

    public function connect()
    {
        if (!Auth::check()) {
            return redirect()
                ->back()
                ->withErrors(['msg' => 'Not logged in.']);
        }

        $user = Auth::user();

        $tetrioId = $user->getLinkedTetrio();
        if ($tetrioId == null) {
            return redirect()
                ->back()
                ->withErrors(['msg' => 'No TETR.IO accounts connected with this Discord account. Make sure "Display publicly" is enabled!']);
        }

        $tetrioUser = TetrioUser::updateOrCreateFromId($tetrioId);

        $user->tetrio_user_id = $tetrioUser->id;
        $user->save();

        return redirect()->back();
    }
}
