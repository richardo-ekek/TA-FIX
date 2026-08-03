<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class NewPasswordController extends Controller
{
    /**
     * 1. Verifikasi OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|numeric',
        ]);

        $tokenRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$tokenRecord) {
            return back()->withErrors([
                'otp' => 'Kode OTP tidak valid atau telah kedaluwarsa.'
            ]);
        }

        // Membuat Signed URL yang berlaku selama 30 menit
        $url = URL::temporarySignedRoute(
            'otp.new_password',
            now()->addMinutes(30),
            [
                'email' => $request->email,
            ]
        );

        return redirect($url);
    }

    /**
     * 2. Menampilkan form password baru
     */
    public function create(Request $request, $email)
    {
        return view('auth.reset-password', [
            'email' => $email,
        ]);
    }

    /**
     * 3. Menyimpan password baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan.'
            ]);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus OTP setelah berhasil digunakan
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('login')->with(
            'status',
            'Password berhasil diubah. Silakan login menggunakan password baru.'
        );
    }
}