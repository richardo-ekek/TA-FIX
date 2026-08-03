<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MouPks;
use App\Models\TikKemlu;
use App\Models\TikNonKemlu;
use App\Models\ActivityLog;
use App\Models\Appointment;
use App\Models\Berita; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    /**
     * Menampilkan halaman Dashboard Utama (SPA).
     */
    public function index()
    {
        $user = auth()->user();
        
        // DIUBAH: Ambil daftar Admin & Tim Hukum beserta Profilnya
        $admins = User::with('profile')
            ->whereIn('role', ['admin', 'tim_hukum'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // DIUBAH: Ambil SEMUA draf kebijakan yang HANYA SUDAH LOLOS TIM HUKUM (pending_superadmin)
// 2. Ambil SEMUA draf kebijakan yang HANYA SUDAH LOLOS TIM HUKUM
        $mouPending = MouPks::where('status', 'pending_superadmin')->get()
            ->map(function($i) { $i->kategori = 'mou'; $i->tipe = 'MoU/PKS'; $i->judul = $i->perihal; return $i; });
        
        $tikKemluPending = TikKemlu::where('status', 'pending_superadmin')->get()
            ->map(function($i) { $i->kategori = 'tik_kemlu'; $i->tipe = 'TIK Kemlu'; $i->judul = $i->perihal; return $i; });
        
        $tikNonKemluPending = TikNonKemlu::where('status', 'pending_superadmin')->get()
            ->map(function($i) { $i->kategori = 'tik_non_kemlu'; $i->tipe = 'TIK Non-Kemlu'; $i->judul = $i->perihal; return $i; });
        
        $allPending = $mouPending->concat($tikKemluPending)->concat($tikNonKemluPending)->sortBy('created_at');
        $logs = ActivityLog::orderBy('created_at', 'desc')->take(10)->get();
        $jadwals = Appointment::with('user')->where('status', 'approved')->whereNotNull('tanggal_waktu_pertemuan')->orderBy('tanggal_waktu_pertemuan', 'asc')->get();
        $beritas = Berita::with('admin')->orderBy('created_at', 'desc')->get();

        // ==========================================
        // DATA UNTUK VISUALISASI CHART.JS
        // ==========================================
        
        // Chart 1: Total Views per Kategori
        $chartViews = [
            'labels' => ['Berita', 'MoU / PKS', 'TIK Kemlu', 'TIK Non-Kemlu'],
            'data' => [
                Berita::sum('views'),
                MouPks::sum('views'),
                TikKemlu::sum('views'),
                TikNonKemlu::sum('views')
            ]
        ];

        // Chart 2: Total Unggahan per Admin / Tim Hukum
        $chartUploads = [
            'labels' => [], 
            'all'       => ['total' => [], 'approved' => [], 'rejected' => [], 'pending' => []],
            'berita'    => ['total' => [], 'approved' => [], 'rejected' => [], 'pending' => []],
            'kebijakan' => ['total' => [], 'approved' => [], 'rejected' => [], 'pending' => []],
        ];

        foreach ($admins as $adm) {
            $id = $adm->id;
            // Menambahkan label role pada nama di grafik
            $labelName = $adm->name . ' (' . strtoupper(str_replace('_', ' ', $adm->role)) . ')';
            $chartUploads['labels'][] = $labelName;

            // Hitung Berita (Termasuk status 'revisi' ke dalam kelompok pending)
            $b_all = Berita::where('admin_id', $id)->count();
            $b_app = Berita::where('admin_id', $id)->where('status', 'approved')->count();
            $b_rej = Berita::where('admin_id', $id)->where('status', 'rejected')->count();
            $b_pen = Berita::where('admin_id', $id)->whereIn('status', ['pending', 'revisi'])->count();

            // Hitung MoU/PKS (Menggabungkan status proses, revisi, dan pending dua lapis)
            $m_all = MouPks::where('admin_id', $id)->count();
            $m_app = MouPks::where('admin_id', $id)->where('status', 'aktif')->count();
            $m_rej = MouPks::where('admin_id', $id)->where('status', 'tidak aktif')->count();
            $m_pen = MouPks::where('admin_id', $id)->whereIn('status', ['pending', 'dalam proses', 'revisi', 'revisi_hukum', 'revisi_superadmin', 'pending_hukum', 'pending_superadmin'])->count();

            // Hitung TIK Kemlu (Menggabungkan status revisi dan pending dua lapis)
            $tk_all = TikKemlu::where('admin_id', $id)->count();
            $tk_app = TikKemlu::where('admin_id', $id)->where('status', 'approved')->count();
            $tk_rej = TikKemlu::where('admin_id', $id)->where('status', 'rejected')->count();
            $tk_pen = TikKemlu::where('admin_id', $id)->whereIn('status', ['pending', 'revisi', 'revisi_hukum', 'revisi_superadmin', 'pending_hukum', 'pending_superadmin'])->count();

            // Hitung TIK Non-Kemlu (Menggabungkan status revisi dan pending dua lapis)
            $tn_all = TikNonKemlu::where('admin_id', $id)->count();
            $tn_app = TikNonKemlu::where('admin_id', $id)->where('status', 'approved')->count();
            $tn_rej = TikNonKemlu::where('admin_id', $id)->where('status', 'rejected')->count();
            $tn_pen = TikNonKemlu::where('admin_id', $id)->whereIn('status', ['pending', 'revisi', 'revisi_hukum', 'revisi_superadmin', 'pending_hukum', 'pending_superadmin'])->count();

            // Gabungkan 3 Jenis Kebijakan
            $k_all = $m_all + $tk_all + $tn_all;
            $k_app = $m_app + $tk_app + $tn_app;
            $k_rej = $m_rej + $tk_rej + $tn_rej;
            $k_pen = $m_pen + $tk_pen + $tn_pen;

            // Masukkan data 'Hanya Berita'
            $chartUploads['berita']['total'][] = $b_all;
            $chartUploads['berita']['approved'][] = $b_app;
            $chartUploads['berita']['rejected'][] = $b_rej;
            $chartUploads['berita']['pending'][] = $b_pen;

            // Masukkan data 'Hanya Kebijakan'
            $chartUploads['kebijakan']['total'][] = $k_all;
            $chartUploads['kebijakan']['approved'][] = $k_app;
            $chartUploads['kebijakan']['rejected'][] = $k_rej;
            $chartUploads['kebijakan']['pending'][] = $k_pen;

            // Masukkan data 'Semua (Total)'
            $chartUploads['all']['total'][] = $b_all + $k_all;
            $chartUploads['all']['approved'][] = $b_app + $k_app;
            $chartUploads['all']['rejected'][] = $b_rej + $k_rej;
            $chartUploads['all']['pending'][] = $b_pen + $k_pen;
        }

        return view('super_admin.dashboard', compact('user', 'admins', 'allPending', 'logs', 'jadwals', 'beritas', 'chartViews', 'chartUploads'));
    }

    /**
     * Membuat Akun Admin / Tim Hukum Baru.
     */
    public function storeAdmin(Request $request)
    {
        // DIUBAH: Tambahkan validasi untuk input role
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,tim_hukum', 
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // DIUBAH: Mengambil dari dropdown form
        ]);

        $namaRole = $request->role === 'tim_hukum' ? 'Tim Hukum' : 'Admin Operasional';
        return redirect()->back()->with('success', "Akun {$namaRole} berhasil ditambahkan!");
    }

    /**
     * Menghapus Akun Admin / Tim Hukum.
     */
    public function destroyAdmin($id)
    {
        $admin = User::findOrFail($id);
        
        // DIUBAH: Diizinkan menghapus role 'admin' atau 'tim_hukum'
        if (in_array($admin->role, ['admin', 'tim_hukum'])) {
            $admin->delete();
            return redirect()->back()->with('success', 'Akun berhasil dihapus!');
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

        $request->validate(['status' => 'required|in:approved,rejected,revisi']);

        $kebijakan->super_admin_id = auth()->id(); // Rekam siapa Super Adminnya
        
        // Variable untuk ActivityLog
        $catatanLog = '';
        
        if ($request->status === 'approved') {
            $kebijakan->status = ($kategori === 'mou') ? 'aktif' : 'approved';
            $kebijakan->keterangan_tambahan = $request->keterangan_tambahan;
            $kebijakan->alasan_penolakan = null;
            $catatanLog = $request->keterangan_tambahan ?: 'Dokumen disetujui';
        } elseif ($request->status === 'rejected') {
            $kebijakan->status = ($kategori === 'mou') ? 'tidak aktif' : 'rejected';
            $kebijakan->alasan_penolakan = $request->alasan_penolakan;
            $catatanLog = $request->alasan_penolakan ?: 'Dokumen ditolak';
        } else {
            // ================================================================
            // TRACKING REVISI SUPER ADMIN
            // ================================================================
            $kebijakan->status = 'revisi_superadmin';
            $kebijakan->revisi_ke = ($kebijakan->revisi_ke ?? 0) + 1; // Tambah angka hitungan revisi
            
            // Format pesan riwayat: "Revisi 2: Super Admin"
            $logBaru = "Revisi " . $kebijakan->revisi_ke . ": Super Admin (" . auth()->user()->name . ") - " . ($request->alasan_penolakan ?: 'Tanpa catatan');
            
            // Gabungkan dengan riwayat revisi sebelumnya (jika sudah pernah direvisi)
            $kebijakan->riwayat_revisi = $kebijakan->riwayat_revisi 
                ? $kebijakan->riwayat_revisi . " | " . $logBaru 
                : $logBaru;
                
            $kebijakan->alasan_penolakan = $request->alasan_penolakan;
            $catatanLog = $request->alasan_penolakan ?: 'Revisi ke-' . $kebijakan->revisi_ke;
        }
        
        $kebijakan->save();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'admin_name' => auth()->user()->name,
            'kategori_dokumen' => strtoupper(str_replace('_', ' ', $kategori)),
            'perihal_dokumen' => $kebijakan->perihal,
            'aksi' => ucfirst($request->status),
            'catatan' => $catatanLog,
        ]);

        return redirect()->back()->with('success', 'Tinjauan dokumen berhasil diproses.');
    }

    /**
     * Memproses Persetujuan Berita.
     */
    public function reviewBerita(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);
        
        // Tambahkan 'revisi' pada validasi
        $request->validate(['status' => 'required|in:approved,rejected,revisi']);

        $berita->update([
            'status' => $request->status,
            'alasan_penolakan' => in_array($request->status, ['rejected', 'revisi']) ? $request->alasan_penolakan : null,
        ]);

        if ($request->status == 'approved') {
            $pesan = 'Berita berhasil dipublikasikan ke Portal User!';
        } elseif ($request->status == 'revisi') {
            $pesan = 'Berita dikembalikan ke Admin untuk direvisi.';
        } else {
            $pesan = 'Berita ditolak.';
        }

        return redirect()->back()->with('success', $pesan);
    }

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