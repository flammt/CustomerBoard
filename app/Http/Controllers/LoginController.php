<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{

    public function authenticate (Request $request) {
        return redirect('/');
        $credentials = $request->only('email', 'password');
        Log::debug('Anmeldungsversuch: ', [$credentials['email']]);
        if (Auth::attempt($credentials)) {
            Log::info('Anmeldung erfolgreich: ', [$credentials['email']]);
            return redirect('/');
        } else {
            Log::info('Anmeldung fehlgeschlagen: ', [$credentials['email']]);
            $user = User::withTrashed()->where('email', $request->input('email'))->get();
            return redirect()->back();
        }
    }

    public function logout (Request $request) {
//        Auth::logout();
        return redirect('/login');
    }
}
