<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Email atau password salah.',
                ]);
        }

        $request->session()->regenerate();

        return redirect($this->homeRoute($request->user()));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function homeRoute(\App\Models\User $user): string
    {
        return match ($user->role) {
            'admin' => '/admin/dashboard',
            'guru' => '/guru/dashboard',
            'siswa' => '/siswa/dashboard',
            default => '/login',
        };
    }
}
