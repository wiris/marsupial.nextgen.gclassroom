<?php

namespace App\Http\Controllers;

use App\Connectors\GoogleAuthConnector;
use App\Connectors\GoogleClassroomConnector;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function redirectToGoogleLogin(GoogleAuthConnector $googleAuthConnector)
    {
        return Inertia::location($googleAuthConnector->getOauthUrl());
    }

    public function login(GoogleAuthConnector $googleAuthConnector, GoogleClassroomConnector $gc, Request $request)
    {
        $code = $request->get('code');

        $accessToken = $googleAuthConnector->accessTokenFromAuthCode($code);
        $userinfo = $googleAuthConnector->getUserInfo($accessToken);

        $user = User::firstOrCreate([
            'email' => $userinfo->email,
        ]);

        $user->google_id = $userinfo->id;
        $user->name = $userinfo->givenName . ' ' . $userinfo->familyName;
        $user->google_access_token_json = json_encode($accessToken);
        $user->save();

        if ($gc->isVerifiedTeacher($user) && $user->role != 'admin') {
            $user->role = 'teacher';
            $user->save();
        }

        Auth::login($user, true);

        $redirect = session('redirect');

        return $redirect ? Inertia::location($redirect) : to_route('materials.index');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('home');
    }
}
