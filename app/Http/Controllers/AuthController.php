<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required','string'],
            'password' => ['required','string'],
        ]);
        if (Auth::attempt(['username'=>$credentials['username'],'password'=>$credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            $role = auth()->user()->role;
            return $role === 'admin' ? redirect()->route('admin.dashboard') : redirect()->route('kades.dashboard');
        }
        return back()->withErrors(['username' => 'Username atau password salah'])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.form');
    }
}


