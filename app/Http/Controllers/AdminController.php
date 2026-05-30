<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; 
use App\Mail\AppointmentStatusNotification;
use App\Models\Appointment;
use App\Models\MouPks; 
use App\Models\TikKemlu;
use App\Models\TikNonKemlu;
use App\Models\Berita; 

class AdminController extends Controller
{
    // 1. FUNGSI UTAMA SPA (Memuat Semua Data)
    public function index()
    {
        $appointments = Appointment::orderBy('created_at', 'desc')->get();
        $jadwals = Appointment::with('user')
                    ->where('status', 'approved')
                    ->whereNotNull('tanggal_waktu_pertemuan')
                    ->orderBy('tanggal_waktu_pertemuan', 'asc')
                    ->get();
        $mou = MouPks::all()->map(function($i) { $i->tipe_dokumen = 'MoU/PKS'; $i->judul = $i->perihal; return $i; });
        $tikKemlu = TikKemlu::all()->map(function($i) { $i->tipe_dokumen = 'TIK Kemlu'; $i->judul = $i->perihal; return $i; });
        $tikNon = TikNonKemlu::all()->map(function($i) { $i->tipe_dokumen = 'TIK Non-Kemlu'; $i->judul = $i->perihal; return $i; });
        
        $allKebijakan = $mou->concat($tikKemlu)->concat($tikNon)->sortByDesc('created_at');
        // DATA BARU: Ambil riwayat berita milik Admin yang sedang login
        $riwayatBerita = Berita::where('admin_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('admin.appointment', compact('appointments', 'jadwals', 'allKebijakan', 'riwayatBerita'));
    }

    // 2. FUNGSI SIMPAN BERITA
    public function storeBerita(Request $request)
    {
        $request->validate([
            'kategori' => 'required|in:Dalam Negeri,Mancanegara,Kerjasama',
            'foto'     => 'required|image|mimes:jpeg,png,jpg|max:2048', 
            'judul'    => 'required|string|max:255',
            'tanggal'  => 'required|date',
            'lokasi'   => 'required|string|max:255',
            'lead'     => 'required|string',
            'body'     => 'required|string',
        ]);
        $pathFoto = $request->file('foto')->store('berita_foto', 'public');

        Berita::create([
            'admin_id' => Auth::id(),
            'kategori' => $request->kategori,
            'foto'     => $pathFoto,
            'judul'    => $request->judul,
            'tanggal'  => $request->tanggal,
            'lokasi'   => $request->lokasi,
            'lead'     => $request->lead,
            'body'     => $request->body,
            'closing'  => $request->closing,
            'status'   => 'pending', 
        ]);
        return redirect()->back()->with('success', 'Draf Berita berhasil diajukan!');
    }

    // 3. FUNGSI UPDATE STATUS JANJI TEMU
    public function updateAppointmentStatus(Request $request, $id)
    {
        $appointment = Appointment::with('user')->findOrFail($id);
        
        $appointment->update([
            'status' => $request->status,
            'tanggal_waktu_pertemuan' => $request->tanggal_waktu_pertemuan,
            'link_meeting' => $request->link_meeting,
            'alamat_pertemuan' => $request->alamat_pertemuan,
            'link_maps' => $request->link_maps,                     // Menyimpan link Google Maps
            'keterangan_tambahan' => $request->keterangan_tambahan, // Menyimpan catatan dari admin
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        if ($appointment->user && $appointment->user->email) {
            Mail::to($appointment->user->email)->send(new AppointmentStatusNotification($appointment));
        }
        
        return back()->with('success', 'Status & Jadwal berhasil diperbarui!');
    }

    // 4. FUNGSI SIMPAN KEBIJAKAN
    public function storeMou(Request $request) 
    {
        MouPks::create($request->all());
        return redirect()->back()->with('success', 'Draf MoU/PKS berhasil diajukan!');
    }

    public function storeTikKemlu(Request $request) 
    {
        TikKemlu::create([
            'jenis_kebijakan' => $request->jenis_kebijakan, 
            'nomor_kebijakan' => $request->nomor_kebijakan, 
            'tahun' => $request->tahun, 
            'perihal' => $request->perihal, 
            'tautan' => $request->tautan, 
            'status' => 'pending'
        ]);
        return redirect()->back()->with('success', 'Draf TIK Kemlu berhasil diajukan!');
    }

    public function storeTikNonKemlu(Request $request) 
    {
        TikNonKemlu::create([
            'jenis_kebijakan' => $request->jenis_kebijakan, 
            'nomor_kebijakan' => $request->nomor_kebijakan, 
            'tahun' => $request->tahun, 
            'perihal' => $request->perihal, 
            'instansi' => $request->instansi, 
            'tautan' => $request->tautan, 
            'status' => 'pending'
        ]);
        return redirect()->back()->with('success', 'Draf TIK Non-Kemlu berhasil diajukan!');
    }

    // ==============================================
    // 5. FUNGSI API CERDAS (DENGAN PENANGKAP ERROR)
    // ==============================================

    public function translateApi(Request $request)
    {
        $text = $request->input('text');
        if (!$text) return response()->json(['error' => 'Teks kosong'], 400);

        try {
            $response = Http::withoutVerifying()
                ->withToken(env('GROQ_API_KEY'))
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.3-70b-versatile',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Anda adalah penerjemah profesional Kementerian Luar Negeri. Terjemahkan teks yang diberikan ke dalam Bahasa Indonesia yang baku, formal, dan jurnalistik. HANYA berikan hasil terjemahannya saja.'],
                        ['role' => 'user', 'content' => $text]
                    ]
                ]);
            if ($response->successful()) {
                return response()->json(['translated_text' => $response->json()['choices'][0]['message']['content']]);
            }
            
            return response()->json(['error' => 'Gagal menerjemahkan'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function generateLeadApi(Request $request)
    {
        $body = $request->input('body');
        if (!$body) return response()->json(['error' => 'Body kosong'], 400);

        try {
            $response = Http::withoutVerifying()
                ->withToken(env('GROQ_API_KEY'))
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.3-70b-versatile',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Anda adalah jurnalis senior. Buat ringkasan padat (Lead berita) maksimal 2 kalimat.'],
                        ['role' => 'user', 'content' => $body]
                    ]
                ]);

            if ($response->successful()) {
                return response()->json(['lead' => $response->json()['choices'][0]['message']['content']]);
            }

            return response()->json(['error' => 'Gagal membuat lead'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * UPDATE: Fungsi Radar Global dengan Pencarian Dinamis
     */
    public function radarGlobalApi(Request $request)
    {
        try {
            // 1. Tangkap kata kunci dari form pencarian, jika kosong gunakan default
            $keyword = $request->input('q', 'Indonesia foreign policy OR Kemenlu OR diplomasi');
            $response = Http::withoutVerifying()->get('https://newsdata.io/api/1/news', [
                'apikey'   => env('NEWSDATA_API_KEY'),
                'q'        => $keyword, // 2. Keyword sekarang dinamis
                'language' => 'en,id',
            ]);
            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json([
                'error' => 'NewsData API Menolak: ' . ($response->json()['message'] ?? 'Gagal menarik berita')
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Koneksi Server Gagal: ' . $e->getMessage()], 500);
        }
    }
}