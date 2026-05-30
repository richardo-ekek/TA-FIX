<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MouPks;
use App\Models\TikKemlu;
use App\Models\TikNonKemlu;
use App\Models\ActivityLog;
use App\Models\Appointment;
use App\Models\Berita; // 1. Penambahan Model Berita
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    /**
     * Menampilkan halaman Dashboard Utama (SPA).
     * Semua data dimuat di sini agar navigasi menu lancar tanpa loading.
     */
    public function index()
    {
        $user = auth()->user();
        
        // 1. Ambil daftar Admin Aktif
        $admins = User::where('role', 'admin')->orderBy('created_at', 'desc')->get();
        
        // 2. Ambil SEMUA draf pending dan seragamkan strukturnya
        $mouPending = MouPks::whereIn('status', ['pending', 'dalam proses'])->get()
            ->map(function($i) { 
                $i->kategori = 'mou'; 
                $i->tipe = 'MoU/PKS'; 
                $i->judul = $i->perihal; 
                return $i; 
            });
        
        $tikKemluPending = TikKemlu::where('status', 'pending')->get()
            ->map(function($i) { 
                $i->kategori = 'tik_kemlu'; 
                $i->tipe = 'TIK Kemlu'; 
                $i->judul = $i->perihal; 
                return $i; 
            });
        
        $tikNonKemluPending = TikNonKemlu::where('status', 'pending')->get()
            ->map(function($i) { 
                $i->kategori = 'tik_non_kemlu'; 
                $i->tipe = 'TIK Non-Kemlu'; 
                $i->judul = $i->perihal; 
                return $i; 
            });
        
        // Gabungkan semua pending draf
        $allPending = $mouPending->concat($tikKemluPending)->concat($tikNonKemluPending)->sortBy('created_at');
        
        // 3. Ambil 10 Log Aktivitas terbaru
        $logs = ActivityLog::orderBy('created_at', 'desc')->take(10)->get();

        // 4. Ambil data Rekap Jadwal untuk section SPA Rekap Jadwal
        $jadwals = Appointment::with('user')
                    ->where('status', 'approved')
                    ->whereNotNull('tanggal_waktu_pertemuan') 
                    ->orderBy('tanggal_waktu_pertemuan', 'asc') 
                    ->get();

        // 5. Ambil daftar Berita (Data baru yang ditambahkan)
        $beritas = Berita::with('admin')->orderBy('created_at', 'desc')->get();

        // Kirim semua data ke satu view dashboard utama (Termasuk 'beritas')
        return view('super_admin.dashboard', compact('user', 'admins', 'allPending', 'logs', 'jadwals', 'beritas'));
    }

    /**
     * Membuat Akun Admin Baru.
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->back()->with('success', 'Akun Admin berhasil ditambahkan!');
    }

    /**
     * Menghapus Akun Admin.
     */
    public function destroyAdmin($id)
    {
        $admin = User::findOrFail($id);
        
        if ($admin->role === 'admin') {
            $admin->delete();
            return redirect()->back()->with('success', 'Akun Admin berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Tindakan tidak diizinkan.');
    }

    /**
     * Memproses Persetujuan Dokumen (Universal).
     */
    public function reviewKebijakan(Request $request, $kategori, $id)
    {
        $kebijakan = match($kategori) {
            'mou' => MouPks::findOrFail($id),
            'tik_kemlu' => TikKemlu::findOrFail($id),
            'tik_non_kemlu' => TikNonKemlu::findOrFail($id),
            default => abort(404),
        };

        $request->validate(['status' => 'required|in:approved,rejected']);

        // Logika status khusus untuk MoU
        $kebijakan->status = ($kategori === 'mou') ? ($request->status === 'approved' ? 'aktif' : 'tidak aktif') : $request->status;
        
        $catatan = ($request->status === 'approved') ? $request->keterangan_tambahan : $request->alasan_penolakan;
        
        if ($request->status === 'approved') {
            $kebijakan->keterangan_tambahan = $catatan;
            $kebijakan->alasan_penolakan = null;
        } else {
            $kebijakan->alasan_penolakan = $catatan;
            $kebijakan->keterangan_tambahan = null;
        }

        $kebijakan->save();

        // Catat ke log aktivitas
        ActivityLog::create([
            'user_id' => auth()->id(),
            'admin_name' => auth()->user()->name,
            'kategori_dokumen' => strtoupper(str_replace('_', ' ', $kategori)),
            'perihal_dokumen' => $kebijakan->perihal,
            'aksi' => ($request->status === 'approved') ? 'Approved' : 'Rejected',
            'catatan' => $catatan,
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil diproses.');
    }

    /**
     * Memproses Persetujuan Berita.
     */
    public function reviewBerita(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $berita->update([
            'status' => $request->status,
            'alasan_penolakan' => $request->status == 'rejected' ? $request->alasan_penolakan : null,
        ]);

        $pesan = $request->status == 'approved' ? 'Berita berhasil dipublikasikan ke Portal User!' : 'Berita dikembalikan ke Admin dengan catatan penolakan.';

        return redirect()->back()->with('success', $pesan);
    }

    /**
     * Standalone route untuk rekap jadwal (Opsional).
     */
    public function rekapJadwal()
    {
        $jadwals = Appointment::with('user')
                    ->where('status', 'approved')
                    ->whereNotNull('tanggal_waktu_pertemuan') 
                    ->orderBy('tanggal_waktu_pertemuan', 'asc') 
                    ->get();

        return view('super_admin.rekap_jadwal', compact('jadwals'));
    }
}