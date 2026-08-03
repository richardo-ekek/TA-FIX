<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AppointmentController extends Controller
{
    // Menampilkan halaman form pengajuan
    public function create()
    {
        return view('user.appointment_create');
    }

    // Menangkap data dari form dan menyimpan ke database
    public function store(Request $request)
    {
        // 1. Validasi inputan (Termasuk tipe_pemohon & reCAPTCHA)
        $request->validate([
            'tipe_pemohon' => 'required|in:individu,institusi',
            'instansi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'tujuan' => 'required|string|max:255',
            'detail_tujuan' => 'required|string',
            'mode' => 'required|in:daring,luring',
            'preferensi_waktu' => 'nullable|date',
            'g-recaptcha-response' => 'required',
        ], [
            'tipe_pemohon.required' => 'Silakan pilih kategori pemohon (Individu atau Institusi).',
            'g-recaptcha-response.required' => 'Silakan centang kotak reCAPTCHA untuk membuktikan Anda bukan robot.'
        ]);

        // 2. Verifikasi token reCAPTCHA ke server Google
        $response = Http::withoutVerifying()->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip()
        ]);

        // 3. Jika Google menyatakan itu Bot atau gagal divalidasi
        if (!$response->json('success')) {
            return back()->withErrors(['g-recaptcha-response' => 'Validasi reCAPTCHA gagal, silakan coba lagi.'])->withInput();
        }

        // 4. Jika lolos verifikasi, Simpan ke database menggunakan Model
        Appointment::create([
            'user_id' => Auth::id(),
            'tipe_pemohon' => $request->tipe_pemohon,
            'nama' => Auth::user()->name ?? explode('@', Auth::user()->email)[0], 
            'instansi' => $request->instansi,
            'alamat' => $request->alamat,
            'tujuan' => $request->tujuan,
            'detail_tujuan' => $request->detail_tujuan,
            'mode' => $request->mode,
            'preferensi_waktu' => $request->preferensi_waktu,
            'status' => 'submitted',
        ]);

        // 5. Kembalikan ke dashboard dengan pesan sukses
        return redirect()->route('user.dashboard')->with('success', 'Janji temu berhasil diajukan dan sedang menunggu proses Admin!');
    }
}