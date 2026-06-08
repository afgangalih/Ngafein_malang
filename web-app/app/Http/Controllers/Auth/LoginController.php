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

    public function register(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/'],
            ], [
                'name.required' => 'Nama lengkap wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email ini sudah terdaftar di sistem.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal harus 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.regex' => 'Password harus berupa kombinasi huruf besar, huruf kecil, dan angka.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        }

        $emailLower = strtolower($data['email']);
        $isPolinema = str_ends_with($emailLower, '@polinema.ac.id') || str_ends_with($emailLower, '@student.polinema.ac.id');

        $user = \App\Models\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($data['password']),
            'role' => 'mahasiswa',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil!',
            'redirect' => route('user.home'),
        ]);
    }
}
