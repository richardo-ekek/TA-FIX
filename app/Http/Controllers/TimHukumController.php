<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MouPks;
use App\Models\TikKemlu;
use App\Models\TikNonKemlu;
use App\Models\ActivityLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class TimHukumController extends Controller
{
    /**
     * 1. FUNGSI UTAMA DASBOR SPA TIM HUKUM
     * Menampilkan antrean dan riwayat dokumen untuk Tim Hukum
     */
    public function index()
    {
        // Ambil data dari 3 tabel kebijakan dengan relasi lengkap
        $mou = MouPks::with(['admin', 'timHukum', 'superAdmin'])->get()->map(function($i) { 
            $i->tipe_dokumen = 'MoU/PKS'; 
            $i->kategori_param = 'mou'; 
            $i->judul = $i->perihal; 
            return $i; 
        });
        
        $tikKemlu = TikKemlu::with(['admin', 'timHukum', 'superAdmin'])->get()->map(function($i) { 
            $i->tipe_dokumen = 'TIK Kemlu'; 
            $i->kategori_param = 'tik_kemlu'; 
            $i->judul = $i->perihal; 
            return $i; 
        });
        
        $tikNon = TikNonKemlu::with(['admin', 'timHukum', 'superAdmin'])->get()->map(function($i) { 
            $i->tipe_dokumen = 'TIK Non-Kemlu'; 
            $i->kategori_param = 'tik_non_kemlu'; 
            $i->judul = $i->perihal; 
            return $i; 
        });

        // Gabungkan seluruh dokumen
        $allDokumen = $mou->concat($tikKemlu)->concat($tikNon)->sortByDesc('updated_at');

        // Filter 1: Antrean dokumen yang menunggu verifikasi Tim Hukum
        $antrean = $allDokumen->where('status', 'pending_hukum');

        // Filter 2: Riwayat dokumen yang sudah diproses (memiliki tim_hukum_id atau statusnya sudah maju/revisi)
        $riwayat = $allDokumen->filter(function ($item) {
            return $item->tim_hukum_id == Auth::id() || 
                   in_array($item->status, ['revisi_hukum', 'pending_superadmin', 'revisi_superadmin', 'approved', 'aktif', 'tidak aktif', 'rejected']);
        });

        return view('tim_hukum.dashboard', compact('antrean', 'riwayat'));
    }

    /**
     * 2. FUNGSI PROSES VERIFIKASI / REVIEW OLEH TIM HUKUM
     * Memproses keputusan: Setujui & Teruskan ke Super Admin, atau Kembalikan untuk Revisi
     */
    public function prosesReview(Request $request, $kategori, $id)
    {
        // Cari dokumen berdasarkan kategori
        $kebijakan = match($kategori) {
            'mou' => MouPks::findOrFail($id),
            'tik_kemlu' => TikKemlu::findOrFail($id),
            'tik_non_kemlu' => TikNonKemlu::findOrFail($id),
            default => abort(404, 'Kategori dokumen tidak ditemukan'),
        };

        // Simpan identitas Tim Hukum yang memeriksa
        $kebijakan->tim_hukum_id = Auth::id();

        $filePath = null;
        $aksiLog = '';

        // =========================================================================
        // KONDISI 1: JIKA DOKUMEN DISETUJUI SECARA HUKUM
        // Diteruskan ke Super Admin / Pimpinan
        // =========================================================================
        if ($request->status === 'teruskan' || $request->status === 'approved' || $request->status === 'setujui') {
            
            // Validasi input (file berita acara opsional, catatan opsional)
            $request->validate([
                'file_berita_acara' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                'catatan_hukum' => 'nullable|string|max:1000'
            ]);

            // Cek apakah Tim Hukum mengunggah file Berita Acara sendiri secara manual
            if ($request->hasFile('file_berita_acara')) {
                $filePath = $request->file('file_berita_acara')->store('berita_acara_hukum', 'public');
                $aksiLog = 'Lolos Verifikasi Hukum (BA Manual)';
            } 
            // JIKA TIDAK ADA FILE DIUNGGAH, BUATKAN PDF BERITA ACARA OTOMATIS + TTD DIGITAL
            else {
                $namaTipe = match($kategori) {
                    'mou' => 'MoU / Perjanjian Kerjasama',
                    'tik_kemlu' => 'Kebijakan TIK Internal Kemlu',
                    'tik_non_kemlu' => 'Kebijakan TIK Non-Kemlu',
                };

                $pdfData = [
                    'data' => $kebijakan,
                    'tipe' => $namaTipe,
                    'catatan' => $request->catatan_hukum
                ];

                // Render tampilan Blade PDF menjadi file biner
                $pdf = Pdf::loadView('pdf.berita_acara_hukum', $pdfData);
                
                // Set ukuran kertas A4 Portrait
                $pdf->setPaper('a4', 'portrait');

                // Buat penamaan file yang rapi dan unik
                $fileName = 'BA-HUKUM-' . strtoupper($kategori) . '-' . $kebijakan->id . '-' . time() . '.pdf';
                $filePath = 'berita_acara_hukum/' . $fileName;

                // Simpan otomatis ke penyimpanan lokal (storage/app/public/berita_acara_hukum)
                Storage::disk('public')->put($filePath, $pdf->output());
                
                $aksiLog = 'Lolos Verifikasi Hukum (BA Otomatis + TTD System)';
            }

            // Perbarui status dokumen agar masuk ke antrean Super Admin
            $kebijakan->status = 'pending_superadmin';
            $kebijakan->file_berita_acara = $filePath;
            $kebijakan->keterangan_tambahan = $request->filled('catatan_hukum') 
                ? "Catatan Legal: " . $request->catatan_hukum 
                : 'Dokumen telah lolos verifikasi hukum.';
            $kebijakan->alasan_penolakan = null;

            // Catat log persetujuan legal
            $logBaru = "Disetujui Legal: Tim Hukum (" . Auth::user()->name . ")";
            $kebijakan->riwayat_revisi = $kebijakan->riwayat_revisi 
                ? $kebijakan->riwayat_revisi . " | " . $logBaru 
                : $logBaru;

            $kebijakan->save();

            // Catat ke dalam Log Aktivitas Sistem (Audit Trail)
            ActivityLog::create([
                'user_id' => Auth::id(),
                'admin_name' => Auth::user()->name . ' (Tim Hukum)',
                'kategori_dokumen' => strtoupper(str_replace('_', ' ', $kategori)),
                'perihal_dokumen' => $kebijakan->perihal,
                'aksi' => $aksiLog,
                'catatan' => $request->catatan_hukum ?: '-',
            ]);

            return redirect()->back()->with('success', 'Dokumen dinyatakan lolos verifikasi legalitas dan telah diteruskan ke Pimpinan (Super Admin)!');
        }

        // =========================================================================
        // KONDISI 2: JIKA DOKUMEN KURANG TEPAT & DIMINTA REVISI
        // Dikembalikan ke Admin untuk perbaikan
        // =========================================================================
        if ($request->status === 'revisi' || $request->status === 'tolak') {
            
            // Validasi: wajib menyertakan alasan revisi
            $request->validate([
                'catatan_hukum' => 'required|string|min:5'
            ], [
                'catatan_hukum.required' => 'Wajib menyertakan alasan atau poin pasal yang harus diperbaiki.',
                'catatan_hukum.min' => 'Alasan revisi minimal 5 karakter.'
            ]);

            // Tracking Revisi Tim Hukum
            $kebijakan->status = 'revisi_hukum';
            $kebijakan->revisi_ke = ($kebijakan->revisi_ke ?? 0) + 1;
            
            // Format log revisi kronologis
            $logBaru = "Revisi " . $kebijakan->revisi_ke . ": Tim Hukum (" . Auth::user()->name . ") - " . $request->catatan_hukum;
            
            // Gabungkan dengan riwayat revisi sebelumnya
            $kebijakan->riwayat_revisi = $kebijakan->riwayat_revisi 
                ? $kebijakan->riwayat_revisi . " | " . $logBaru 
                : $logBaru;

            $kebijakan->alasan_penolakan = $request->catatan_hukum;
            $aksiLog = 'Revisi Hukum (Revisi ke-' . $kebijakan->revisi_ke . ')';
            
            $kebijakan->save();

            // Catat ke dalam Log Aktivitas Sistem (Audit Trail)
            ActivityLog::create([
                'user_id' => Auth::id(),
                'admin_name' => Auth::user()->name . ' (Tim Hukum)',
                'kategori_dokumen' => strtoupper(str_replace('_', ' ', $kategori)),
                'perihal_dokumen' => $kebijakan->perihal,
                'aksi' => $aksiLog,
                'catatan' => $request->catatan_hukum,
            ]);

            return redirect()->back()->with('success', 'Dokumen dikembalikan ke Admin untuk dilakukan perbaikan (Revisi ke-' . $kebijakan->revisi_ke . ').');
        }

        // Jika aksi tidak dikenali
        return redirect()->back()->with('error', 'Aksi tidak dikenali.');
    }

    /**
     * 3. FUNGSI MELIHAT DETAIL DOKUMEN (GET)
     * Menampilkan halaman detail/review dokumen untuk Tim Hukum
     */
    public function showReview($kategori, $id)
    {
        $kebijakan = match($kategori) {
            'mou' => MouPks::with(['admin', 'timHukum', 'superAdmin'])->findOrFail($id),
            'tik_kemlu' => TikKemlu::with(['admin', 'timHukum', 'superAdmin'])->findOrFail($id),
            'tik_non_kemlu' => TikNonKemlu::with(['admin', 'timHukum', 'superAdmin'])->findOrFail($id),
            default => abort(404, 'Kategori dokumen tidak dikenali.'),
        };

        $namaTipe = match($kategori) {
            'mou' => 'MoU / Perjanjian Kerjasama',
            'tik_kemlu' => 'Kebijakan TIK Internal Kemlu',
            'tik_non_kemlu' => 'Kebijakan TIK Non-Kemlu',
        };

        return view('tim_hukum.review', compact('kebijakan', 'kategori', 'namaTipe'));
    }
}