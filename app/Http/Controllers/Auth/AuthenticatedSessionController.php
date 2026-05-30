<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // Tambahan untuk reCAPTCHA
use Illuminate\Validation\ValidationException; // Tambahan untuk reCAPTCHA
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // ==========================================
        // 1. PENGECEKAN RECAPTCHA SEBELUM LOGIN
        // ==========================================
        $request->validate([
            'g-recaptcha-response' => 'required',
        ], [
            'g-recaptcha-response.required' => 'Silakan centang kotak "Saya bukan robot" terlebih dahulu.'
        ]);

        $response = Http::withoutVerifying()->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip()
        ]);

        if (!$response->json('success')) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => __('Validasi keamanan gagal, silakan *refresh* halaman dan coba lagi.'),
            ]);
        }
        // ==========================================

        // 2. PROSES LOGIN BAWAAN LARAVEL
        $request->authenticate();
        $request->session()->regenerate();

        // 3. LOGIKA PENGALIHAN (REDIRECT) BERDASARKAN ROLE
        $role = $request->user()->role;

        if ($role === 'super_admin') {
            return redirect()->intended('/super-admin/dashboard');
        } elseif ($role === 'admin') {
            return redirect()->intended('/admin/appointment');
        }

        // Default untuk user biasa
        return redirect()->intended('/user/dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}