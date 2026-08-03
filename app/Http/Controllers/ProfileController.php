<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    // FUNGSI MENGIRIM EMAIL OTP SUNGGUHAN (GMAIL SMTP)
    public function sendEmailOtp(\Illuminate\Http\Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $user = \App\Models\User::where('email', $request->email)->first();
        if (!$user) { return response()->json(['success' => false, 'message' => 'Email tidak terdaftar di sistem!']); }

        // Buat 4 digit OTP rahasia
        $otp = rand(1000, 9999);
        
        // Simpan OTP di session memori sementara
        Session::put('otp_' . $request->email, $otp);

        // Kirim email
        try {
            Mail::raw("Halo " . $user->name . ",\n\nKode OTP Rahasia Anda untuk mengatur ulang kata sandi adalah: " . $otp . "\n\nJangan berikan kode ini kepada siapapun demi keamanan akun Anda.\n\nSalam,\nSistem Portal SPA", function($message) use ($user) {
                $message->to($user->email)->subject('Kode OTP Pemulihan Akun SPA Kemlu');
            });
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengirim email. Pastikan koneksi internet dan setingan SMTP .env benar.']);
        }
    }

    // FUNGSI VERIFIKASI KODE OTP EMAIL DARI INPUTAN USER
    public function verifyEmailOtp(\Illuminate\Http\Request $request)
    {
        $savedOtp = Session::get('otp_' . $request->email);

        if ($savedOtp && $savedOtp == $request->otp) {
            Session::forget('otp_' . $request->email); // Hapus otp setelah sukses
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Kode OTP Salah atau Kadaluarsa!']);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update password custom.
     */
    public function updatePasswordCustom(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'current_password.current_password' => 'Password lama Anda salah.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Kata sandi Anda berhasil diperbarui demi keamanan akun!');
    }

    /**
     * Update detail profil user/admin.
     */
    public function updateProfileDetail(Request $request)
    {
        $user = $request->user();

        // Simpan data universal (berlaku untuk semua role)
        $user->name = $request->name ?? $user->name;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->alamat = $request->alamat;
        $user->no_telp = $request->no_telp; // Admin & Super Admin juga bisa menyimpan no_telp

        // Simpan data berdasarkan role
        if ($user->role === 'user') {
            $user->pekerjaan = $request->pekerjaan;
        } else {
            $user->nip = $request->nip;
            $user->jabatan = $request->jabatan;
        }

        $user->save();

        return back()->with('success', 'Data Profil berhasil dilengkapi!');
    }

    /**
     * FUNGSI BARU: Memproses pengunggahan dan pembaruan foto profil user/admin.
     */
    public function updateFotoProfil(Request $request)
    {
        // 1. Validasi gambar max 2MB
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'foto_profil.required' => 'Silakan pilih foto terlebih dahulu.',
            'foto_profil.image' => 'Berkas yang diunggah harus berupa gambar.',
            'foto_profil.max' => 'Ukuran foto maksimal adalah 2MB.',
        ]);

        $user = auth()->user();

        // 2. Hapus foto lama di penyimpanan jika sebelumnya sudah punya foto profil
        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        // 3. Simpan foto baru ke direktori storage/app/public/foto_profil
        $path = $request->file('foto_profil')->store('foto_profil', 'public');

        // 4. Perbarui path foto di database
        $user->foto_profil = $path;
        $user->save();

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    /**
     * Validasi email dan nomor telepon untuk OTP lupa password.
     */
    public function checkPhoneOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'no_telp' => 'required',
        ]);

        $exists = User::where('email', $request->email)
            ->where('no_telp', $request->no_telp)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'DITOLAK: Nomor telepon tidak terdaftar atau tidak cocok dengan email tersebut!',
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Reset Password Final setelah OTP divalidasi (Tambahan Baru)
     */
    public function resetPasswordFinal(Request $request)
    {
        // 1. Validasi input: Pastikan ada email, dan password minimal 8 karakter & cocok
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // 2. Cari user berdasarkan email yang dikirim dari form Step 4 (hidden input)
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if ($user) {
            // 3. Enkripsi password baru dan simpan ke database
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // 4. Arahkan kembali ke halaman login
        return redirect()->route('login')->with('status', 'Password berhasil diubah. Silakan login dengan kata sandi baru Anda.');
    }
}