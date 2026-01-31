<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login_proses(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $login = [
            'email' => $request->email,
            'password' => $request->password,
        ];


        if (Auth::attempt($login)) {
            $user = Auth::user();
            if ($user->usertype == 'admin') {
                return redirect()->route('admin-home');
            } elseif ($user->usertype == 'user') {
                return redirect()->route('user-home', ['user' => $user->id]);
            } elseif ($user->usertype == 'developer') {
                return redirect()->route('developer-home', ['user' => $user->id]);
            };
        } else {
            return redirect('');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.user');
    }
}



