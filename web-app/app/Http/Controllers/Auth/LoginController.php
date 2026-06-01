<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return redirect()->route($user->isAdmin() ? 'admin.dashboard' : 'user.home');
        }
        return view('admin.auth.login');
    }

    /**
     * Handle authentication attempt.
     */
    public function login(Request $request)
    {
        // Custom validation that works with both JSON and regular redirect
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'string', 'min:6'],
            ], [
                'email.required' => 'Waduh, emailnya jangan lupa diisi ya!',
                'email.email' => 'Format email kamu sepertinya belum bener nih.',
                'password.required' => 'Passwordnya wajib diisi, Bos!',
                'password.min' => 'Password minimal harus 6 karakter ya.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors(),
                ], 422);
            }
            throw $e;
        }

        // Throttling: Limit login attempts to 5 per minute
        $throttleKey = strtolower($request->input('email')) . '|' . $request->ip();
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($throttleKey);
            $msg = "Terlalu banyak percobaan login. Silakan coba lagi dalam $seconds detik.";
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['email' => [$msg]]
                ], 422);
            }
            return back()->withErrors([
                'email' => $msg,
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->remember)) {
            $user = Auth::user();

            // Cross-login Prevention
            if ($request->expectsJson()) {
                // User modal login (AJAX): block admins
                if ($user->isAdmin()) {
                    Auth::logout();
                    return response()->json([
                        'success' => false,
                        'errors' => ['email' => ['Akun Admin tidak diizinkan masuk melalui portal Mahasiswa.']]
                    ], 422);
                }
            } else {
                // Admin page login: block non-admins
                if (!$user->isAdmin()) {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'Akun Mahasiswa tidak memiliki akses ke panel Admin.',
                    ])->onlyInput('email');
                }
            }

            \Illuminate\Support\Facades\RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            $redirectUrl = $user->isAdmin() ? route('admin.dashboard') : route('user.home');

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil!',
                    'redirect' => $redirectUrl,
                ]);
            }

            return redirect()->intended($redirectUrl);
        }

        \Illuminate\Support\Facades\RateLimiter::hit($throttleKey);

        $msg = 'Email atau password yang Anda masukkan salah.';
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'errors' => ['email' => [$msg]]
            ], 422);
        }

        return back()->withErrors([
            'email' => $msg,
        ])->onlyInput('email');
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.home');
    }
}
