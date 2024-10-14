<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{

    public function login(): mixed
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        $loginUrl = route('authenticate');

        return view('auth.login', compact('loginUrl'));
    }

    public function authenticate(LoginRequest $request): RedirectResponse
    {

        if (Auth::attempt($request->only('email', 'password'))) {

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => __('auth.failed'), 
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 

        return redirect()->route('login'); 
    }
}
