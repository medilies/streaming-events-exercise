<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class OauthController
{
    public function redirect(string $idp)
    {
        return Socialite::driver($idp)->stateless()->redirect();
    }

    public function callback(string $idp)
    {
        $oAuthUser = Socialite::driver($idp)->stateless()->user();

        $user = User::where('email', $oAuthUser->email)->first();

        $user ??= User::create([
            'name' => $oAuthUser->name,
            'email' => $oAuthUser->email,
        ]);

        $token = $user->createToken('token');

        return ['token' => $token->plainTextToken];
    }
}
