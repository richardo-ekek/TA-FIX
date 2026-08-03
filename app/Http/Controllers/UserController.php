<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\MouPks; 
use App\Models\TikKemlu;
use App\Models\TikNonKemlu;
use App\Models\Berita; 

class UserController extends Controller
{
    public function dashboard()
    {
        // 1. Data Janji Temu User
        $appointments = Appointment::where('user_id', auth()->id())
                        ->orderBy('created_at', 'desc')->get();

        // 2. Data Arsip Kebijakan
        $mou = MouPks::all()->map(function($i) { 
            $i->tipe_dokumen = 'MoU/PKS'; 
            $i->judul = $i->perihal; 
            return $i; 
        });
        
        $tikKemlu = TikKemlu::all()->map(function($i) { 
            $i->tipe_dokumen = 'TIK Kemlu'; 
            $i->judul = $i->perihal; 
            return $i; 
        });
        
        $tikNon = TikNonKemlu::all()->map(function($i) { 
            $i->tipe_dokumen = 'TIK Non-Kemlu'; 
            $i->judul = $i->perihal; 
            return $i; 
        });
        
        $allKebijakan = $mou->concat($tikKemlu)->concat($tikNon)->sortByDesc('created_at');

        // 3. Ambil Berita yang sudah disetujui (Approved)
        $beritaList = Berita::with('admin')
                        ->where('status', 'approved')
                        ->orderBy('tanggal', 'desc')
                        ->get();

        return view('user.dashboard', compact('appointments', 'allKebijakan', 'beritaList'));
    }

    /**
     * FUNGSI BARU: Mencatat jumlah Views saat User membaca Berita / Kebijakan
     */
    public function recordView(Request $request)
    {
        $id = $request->id;
        $tipe = $request->tipe_dokumen; 

        // Logika penambahan angka views (+1) langsung ke database
        if ($tipe === 'Berita') {
            Berita::where('id', $id)->increment('views');
        } elseif ($tipe === 'MoU/PKS') {
            MouPks::where('id', $id)->increment('views');
        } elseif ($tipe === 'TIK Kemlu') {
            TikKemlu::where('id', $id)->increment('views');
        } elseif ($tipe === 'TIK Non-Kemlu') {
            TikNonKemlu::where('id', $id)->increment('views');
        }

        return response()->json(['success' => true]);
    }
}