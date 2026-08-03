<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CustomResetController extends Controller
{
    // 1. Menampilkan form minta OTP (Input Email)
    public function showForgotForm()
    {
        return view('custom-auth.minta-otp');
    }

    // 2. Membuat OTP dan Mengirim Email
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $email = $request->email;

        // Buat 6 digit angka acak
        $otp = rand(100000, 999999);

        // Simpan ke database (timpa jika email sudah pernah minta)
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => $otp, 'created_at' => now()]
        );

        // Coba kirim email. Jika gagal, tampilkan error aslinya.
        try {
            Mail::raw("Kode OTP Reset Password Anda adalah: $otp", function ($message) use ($email) {
                $message->to($email)->subject('Kode OTP Anda');
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal kirim email karena: ' . $e->getMessage());
        }

        // Jika berhasil, kirim email ke halaman verifikasi
        return view('custom-auth.validasi-otp', ['email' => $email]);
    }

    // 3. Memvalidasi OTP dan Langsung Menampilkan Form Password Baru
    public function verifyOtpAndShowForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|numeric'
        ]);

        $valid = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$valid) {
            return back()->with('error', 'Kode OTP Salah!');
        }

        // OTP BENAR! Langsung tampilkan view form password (tanpa session/redirect)
        return view('custom-auth.password-baru', [
            'email' => $request->email,
            'otp'   => $request->otp // Kita bawa OTP ini untuk validasi terakhir
        ]);
    }

    // 4. Menyimpan Password Baru ke Database
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'otp'      => 'required|numeric',
            'password' => 'required|min:8|confirmed'
        ]);

        // Validasi OTP sekali lagi untuk keamanan ekstra
        $valid = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$valid) {
            return redirect()->route('custom.forgot')->with('error', 'Akses tidak sah atau OTP sudah hangus.');
        }

        // Update User
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        // Hapus OTP
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Selesai!
        return redirect()->route('login')->with('status', 'Berhasil! Silakan login dengan password baru.');
    }
}