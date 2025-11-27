<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            if ($user->isPlatform()) {
                return redirect()->intended('/platform/dashboard');
            }
            
            if ($user->isSeller()) {
                $seller = $user->seller;
                if (!$seller || $seller->status !== 'approved' || !$seller->is_active) {
                    Auth::logout();
                    throw ValidationException::withMessages([
                        'email' => 'Akun penjual Anda belum diverifikasi atau tidak aktif.',
                    ]);
                }
                return redirect()->intended('/seller/dashboard');
            }
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password tidak valid.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
