<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginpost(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, true)) {
            return redirect()->intended('/');
        }

        return redirect()->back()->withErrors(['message' => 'Credenciais inválidas']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route("main"));
    }
}
