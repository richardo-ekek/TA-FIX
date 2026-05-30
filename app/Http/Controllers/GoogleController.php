<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    // 1. Mengarahkan user ke halaman login Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Menangani kembalian (callback) dari Google setelah sukses login
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Menggunakan updateOrCreate untuk menyederhanakan kode
            $user = User::updateOrCreate(
                ['email' => $googleUser->email], //条件: cek berdasarkan email
                [
                    'name' => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt(Str::random(16)), // Password acak via Google
                    'role' => 'user', // Otomatis menjadi user biasa
                ]
            );
            
            // Login user
            Auth::login($user);

            // Setelah login berhasil, arahkan ke dashboard
            return redirect('/dashboard'); 

        } catch (\Exception $e) {
            // Tampilkan pesan error asli dari sistem
            return redirect('/login')->with('error', 'Error Sistem: ' . $e->getMessage());
        }
    }
}