<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - Pusat Komando</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-50 font-sans flex min-h-screen">

    <div class="w-64 bg-indigo-950 text-white flex flex-col shadow-2xl z-20">
        <div class="p-6 text-xl font-extrabold border-b border-indigo-900/50 flex items-center gap-2">
            <div class="bg-indigo-600 p-1.5 rounded-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            Super Admin
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2">
            <button type="button" onclick="switchMenu('manajemen')" id="btn-manajemen" class="w-full text-left px-4 py-3 bg-indigo-800 rounded-xl text-white font-bold shadow-lg shadow-indigo-900/50 transition">
                Manajemen Pusat
            </button>
            <button type="button" onclick="switchMenu('tinjauan')" id="btn-tinjauan" class="w-full text-left px-4 py-3 rounded-xl text-indigo-300 hover:bg-indigo-800 hover:text-white transition font-medium">
                Tinjauan Draf Kebijakan
            </button>
            <button type="button" onclick="switchMenu('rekap_jadwal')" id="btn-rekap_jadwal" class="w-full text-left px-4 py-3 rounded-xl text-indigo-300 hover:bg-indigo-800 hover:text-white transition font-medium">
                Rekap Jadwal
            </button>
            <button type="button" onclick="switchMenu('berita')" id="btn-berita" class="w-full text-left px-4 py-3 rounded-xl text-indigo-300 hover:bg-indigo-800 hover:text-white transition font-medium">
                Tinjauan Berita
            </button>
            <button type="button" onclick="switchMenu('log')" id="btn-log" class="w-full text-left px-4 py-3 rounded-xl text-indigo-300 hover:bg-indigo-800 hover:text-white transition font-medium">
                Log Aktivitas
            </button>
        </nav>

        <div class="p-4 border-t border-indigo-900/50">
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="flex justify-center items-center gap-2 w-full bg-indigo-900/50 hover:bg-red-500/20 hover:text-red-400 py-3 rounded-xl text-sm font-bold transition">Logout</button>
            </form>
        </div>
    </div>

    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <header class="bg-white px-8 py-5 border-b border-slate-200 flex justify-between items-center z-10 shadow-sm">
            <div>
                <h2 id="header-title" class="text-2xl font-extrabold text-slate-800 tracking-tight">Manajemen Akses & Kebijakan</h2>
                <p id="header-desc" class="text-sm text-slate-500 mt-1">Kelola Admin dan tinjau seluruh draf kebijakan dari satu pintu.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="bg-indigo-100 text-indigo-800 text-[10px] font-extrabold uppercase tracking-widest px-3 py-1 rounded-full border border-indigo-200">Pusat Komando</span>
                <span class="text-slate-600 font-bold text-sm">{{ auth()->user()->name ?? 'Super Admin' }}</span>
            </div>
        </header>

        <main class="p-8 flex-1 overflow-y-auto bg-slate-50 custom-scrollbar">
            
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 text-emerald-700 px-4 py-3 rounded-xl font-semibold text-sm">{{ session('success') }}</div>
            @endif

            <div id="section-manajemen" class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Daftar Admin Aktif
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left whitespace-nowrap">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-3 text-xs font-bold text-slate-400 uppercase tracking-wider rounded-l-xl">Info Admin</th>
                                    <th class="px-4 py-3 text-xs font-bold text-slate-400 uppercase tracking-wider text-right rounded-r-xl">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($admins ?? [] as $admin)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="px-4 py-4">
                                            <p class="font-extrabold text-slate-800 text-sm">{{ $admin->name }}</p>
                                            <p class="text-xs text-slate-500">{{ $admin->email }}</p>
                                        </td>
                                        <td class="px-4 py-4 text-right">
                                            <form action="{{ route('super_admin.admin.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Hapus Admin secara permanen?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="bg-red-50 hover:bg-red-500 text-red-600 hover:text-white px-4 py-2 rounded-lg text-xs font-bold transition">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="px-4 py-8 text-center text-slate-500 font-medium italic">Belum ada akun Admin.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Buat Akun Admin</h3>
                    <p class="text-xs text-slate-500 mb-6">Akun otomatis mendapat role Admin operasional.</p>
                    <form action="{{ route('super_admin.admin.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div><label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Nama Lengkap</label>
                            <input type="text" name="name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition"></div>
                        <div><label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Email</label>
                            <input type="email" name="email" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition"></div>
                        <div><label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Password</label>
                            <input type="text" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition" placeholder="Min. 8 karakter"></div>
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold py-3.5 px-4 rounded-xl transition shadow-md">Tambahkan Admin</button>
                    </form>
                </div>
            </div>

            <div id="section-tinjauan" class="hidden">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Tinjauan Draf Kebijakan dan MoU/PKS
                    </h3>
                    <div class="space-y-4">
                        @forelse($allPending ?? [] as $item)
                            <div class="border border-slate-200 rounded-2xl p-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 hover:bg-slate-50 transition border-l-4 border-l-indigo-500">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-widest">{{ $item->tipe }}</span>
                                        <span class="text-[10px] font-bold text-slate-400">Input: {{ $item->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                    <h4 class="font-extrabold text-slate-800 text-base">{{ $item->judul }}</h4>
                                    <p class="text-xs text-slate-500 mt-1">
                                        @if($item->kategori == 'mou') {{ $item->satker_kemlu }} &mdash; {{ $item->instansi_external }}
                                        @else No: {{ $item->nomor_kebijakan }} | Thn: {{ $item->tahun }} @endif
                                    </p>
                                </div>
                                <div class="flex gap-2 w-full md:w-auto shrink-0">
                                    <button type="button" onclick="openSetujuModal('{{ $item->id }}', '{{ $item->kategori }}')" class="bg-emerald-50 hover:bg-emerald-500 text-emerald-600 hover:text-white px-5 py-2 rounded-xl text-xs font-bold transition">Setujui</button>
                                    <button type="button" onclick="openTolakModal('{{ $item->id }}', '{{ $item->kategori }}')" class="bg-red-50 hover:bg-red-500 text-red-600 hover:text-white px-5 py-2 rounded-xl text-xs font-bold transition">Tolak</button>
                                </div>
                            </div>
                        @empty
                            <div class="text-center bg-slate-50 rounded-2xl border border-slate-100 py-10 text-slate-500 font-medium">Tidak ada draf yang menunggu persetujuan.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div id="section-rekap_jadwal" class="hidden">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
                    <h3 class="text-xl font-extrabold text-slate-800 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Rekap Jadwal Pertemuan Disetujui
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-slate-50 text-slate-400 text-[10px] uppercase tracking-widest border-b border-slate-200">
                                    <th class="px-6 py-4 font-extrabold">Waktu Pertemuan</th>
                                    <th class="px-6 py-4 font-extrabold">Instansi / Pemohon</th>
                                    <th class="px-6 py-4 font-extrabold">Tujuan & Mode</th>
                                    <th class="px-6 py-4 font-extrabold text-center">Status Jadwal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($jadwals ?? [] as $jadwal)
                                    @php
                                        $waktuJadwal = \Carbon\Carbon::parse($jadwal->tanggal_waktu_pertemuan)->startOfDay();
                                        $hariIni = \Carbon\Carbon::now()->startOfDay();
                                        $selisihHari = $hariIni->diffInDays($waktuJadwal, false); 
                                        if ($selisihHari < 0) { $warna = 'bg-slate-100 text-slate-500 border-slate-200'; $teks = 'Berlalu'; }
                                        elseif ($selisihHari <= 2) { $warna = 'bg-red-100 text-red-700 border-red-200 animate-pulse'; $teks = 'H-' . $selisihHari . ' (Segera)'; }
                                        elseif ($selisihHari <= 5) { $warna = 'bg-amber-100 text-amber-700 border-amber-200'; $teks = 'H-' . $selisihHari . ' (Mendekati)'; }
                                        else { $warna = 'bg-emerald-100 text-emerald-700 border-emerald-200'; $teks = 'H-' . $selisihHari . ' (Aman)'; }
                                        if ($selisihHari == 0) { $warna = 'bg-red-600 text-white animate-pulse border-red-600'; $teks = 'HARI INI!'; }
                                    @endphp
                                    <tr class="hover:bg-slate-50/80 transition duration-150">
                                        <td class="px-6 py-5">
                                            <div class="font-extrabold text-slate-900 text-sm">{{ \Carbon\Carbon::parse($jadwal->tanggal_waktu_pertemuan)->format('d M Y') }}</div>
                                            <div class="text-[10px] font-bold text-indigo-600 mt-1 bg-indigo-50 inline-block px-2 py-0.5 rounded">{{ \Carbon\Carbon::parse($jadwal->tanggal_waktu_pertemuan)->format('H:i') }} WIB</div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="font-extrabold text-slate-900 text-sm">{{ $jadwal->instansi ?? 'N/A' }}</div>
                                            <div class="text-[10px] font-medium text-slate-500 mt-0.5">{{ $jadwal->user->name ?? 'User Unknown' }}</div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="text-xs font-bold text-slate-800">{{ Str::limit($jadwal->tujuan, 30) }}</div>
                                            <div class="text-[10px] font-extrabold text-slate-500 mt-1 bg-slate-100 px-2 py-0.5 rounded w-fit uppercase">{{ $jadwal->mode }}</div>
                                        </td>
                                        <td class="px-6 py-5 text-center">
                                            <span class="inline-block px-3 py-1.5 rounded-lg text-[10px] font-extrabold tracking-wider border {{ $warna }}">{{ $teks }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-6 py-12 text-center text-slate-400 font-medium italic text-sm">Belum ada jadwal yang disetujui.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="section-berita" class="hidden">
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                        <h3 class="text-lg font-extrabold text-slate-800">Antrean Publikasi Berita</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-slate-50 text-slate-400 text-xs uppercase tracking-widest border-b border-slate-200">
                                    <th class="px-6 py-4 font-extrabold">Tanggal & Penulis</th>
                                    <th class="px-6 py-4 font-extrabold">Informasi Berita</th>
                                    <th class="px-6 py-4 font-extrabold text-center">Status</th>
                                    <th class="px-6 py-4 font-extrabold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($beritas ?? [] as $berita)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="px-6 py-4">
                                            <div class="font-extrabold text-slate-900 text-sm">{{ \Carbon\Carbon::parse($berita->created_at)->format('d M Y, H:i') }}</div>
                                            <div class="text-[10px] font-bold text-slate-500 mt-1 uppercase">Oleh: {{ $berita->admin->name ?? 'Admin' }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-slate-800">{{ Str::limit($berita->judul, 40) }}</div>
                                            <div class="text-[10px] font-extrabold text-blue-600 mt-1 bg-blue-50 px-2 py-0.5 rounded w-fit uppercase">{{ $berita->kategori }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($berita->status == 'pending') <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase animate-pulse">Menunggu Review</span>
                                            @elseif($berita->status == 'approved') <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase">Dipublikasi</span>
                                            @else <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase">Ditolak</span> @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if($berita->status == 'pending')
                                                <div class="hidden" id="berita-foto-{{ $berita->id }}">{{ asset('storage/' . $berita->foto) }}</div>
                                                <div class="hidden" id="berita-kategori-{{ $berita->id }}">{{ $berita->kategori }}</div>
                                                <div class="hidden" id="berita-judul-{{ $berita->id }}">{{ $berita->judul }}</div>
                                                <div class="hidden" id="berita-lokasi-{{ $berita->id }}">{{ $berita->lokasi }}</div>
                                                <div class="hidden" id="berita-tanggal-{{ $berita->id }}">{{ \Carbon\Carbon::parse($berita->tanggal)->format('d M Y') }}</div>
                                                <div class="hidden" id="berita-lead-{{ $berita->id }}">{{ $berita->lead }}</div>
                                                <div class="hidden" id="berita-body-{{ $berita->id }}">{{ $berita->body }}</div>
                                                <div class="hidden" id="berita-closing-{{ $berita->id }}">{{ $berita->closing }}</div>

                                                <button onclick="openReviewBeritaModal('{{ $berita->id }}')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-lg shadow-blue-200">Review Artikel</button>
                                            @else
                                                <div class="hidden" id="berita-foto-{{ $berita->id }}">{{ asset('storage/' . $berita->foto) }}</div>
                                                <div class="hidden" id="berita-kategori-{{ $berita->id }}">{{ $berita->kategori }}</div>
                                                <div class="hidden" id="berita-judul-{{ $berita->id }}">{{ $berita->judul }}</div>
                                                <div class="hidden" id="berita-lokasi-{{ $berita->id }}">{{ $berita->lokasi }}</div>
                                                <div class="hidden" id="berita-tanggal-{{ $berita->id }}">{{ \Carbon\Carbon::parse($berita->tanggal)->format('d M Y') }}</div>
                                                <div class="hidden" id="berita-lead-{{ $berita->id }}">{{ $berita->lead }}</div>
                                                <div class="hidden" id="berita-body-{{ $berita->id }}">{{ $berita->body }}</div>
                                                <div class="hidden" id="berita-closing-{{ $berita->id }}">{{ $berita->closing }}</div>
                                                
                                                <button onclick="openReviewBeritaModal('{{ $berita->id }}')" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-4 py-2 rounded-xl text-xs font-bold transition">Lihat Arsip</button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-6 py-12 text-center text-slate-400 italic text-sm">Belum ada draf berita yang diajukan oleh Admin.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="section-log" class="hidden">
                <div class="bg-indigo-900 rounded-3xl shadow-xl p-8 text-white">
                    <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Log Aktivitas Persetujuan Terkini
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left table-fixed border-collapse">
                            <thead class="text-indigo-300 text-[10px] uppercase tracking-widest border-b border-indigo-800">
                                <tr><th class="px-6 py-4 w-1/6">Waktu</th><th class="px-6 py-4 w-2/6">Dokumen</th><th class="px-6 py-4 w-1/6">Tindakan</th><th class="px-6 py-4">Catatan</th></tr>
                            </thead>
                            <tbody class="divide-y divide-indigo-800/50">
                                @forelse($logs ?? [] as $log)
                                <tr class="text-xs hover:bg-indigo-800/50 transition">
                                    <td class="px-6 py-4 font-medium text-indigo-200">{{ $log->created_at->format('d/m H:i') }}</td>
                                    <td class="px-6 py-4"><span class="block font-bold">{{ $log->perihal_dokumen }}</span><span class="text-[10px] text-indigo-400 uppercase tracking-tighter">{{ $log->kategori_dokumen }}</span></td>
                                    <td class="px-6 py-4">
                                        @if($log->aksi == 'Approved') <span class="bg-emerald-500/20 text-emerald-400 px-2 py-1 rounded text-[10px] font-extrabold uppercase border border-emerald-500/30">Approved</span>
                                        @else <span class="bg-red-500/20 text-red-400 px-2 py-1 rounded text-[10px] font-extrabold uppercase border border-red-500/30">Rejected</span> @endif
                                    </td>
                                    <td class="px-6 py-4 text-indigo-200 italic text-[11px]">{{ Str::limit($log->catatan, 60) }}</td>
                                </tr>
                                @empty <tr><td colspan="4" class="px-4 py-8 text-center text-indigo-400 italic">Belum ada riwayat aktivitas.</td></tr> @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <div id="setujuModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl p-8 w-full max-w-md shadow-2xl animate-in zoom-in duration-200">
            <h3 class="font-extrabold text-xl mb-4 text-emerald-600">Setujui Dokumen</h3>
            <form id="formSetuju" method="POST" action="">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="approved">
                <textarea name="keterangan_tambahan" rows="3" placeholder="Berikan catatan..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm mb-6 outline-none focus:ring-2 focus:ring-emerald-500 transition"></textarea>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeKebijakanModals()" class="px-6 py-2.5 bg-slate-100 rounded-xl font-bold text-slate-500 text-sm">Batal</button>
                    <button type="submit" class="bg-emerald-500 text-white px-6 py-2.5 rounded-xl font-extrabold shadow-md text-sm">Kirim Persetujuan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="tolakModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl p-8 w-full max-w-md shadow-2xl animate-in zoom-in duration-200">
            <h3 class="font-extrabold text-xl mb-4 text-red-600">Tolak Dokumen</h3>
            <form id="formTolak" method="POST" action="">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="rejected">
                <textarea name="alasan_penolakan" required rows="3" placeholder="Alasan penolakan..." class="w-full bg-red-50/50 border border-red-200 rounded-xl p-3 text-sm mb-6 outline-none focus:ring-2 focus:ring-red-500 transition"></textarea>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeKebijakanModals()" class="px-6 py-2.5 bg-slate-100 rounded-xl font-bold text-slate-500 text-sm">Batal</button>
                    <button type="submit" class="bg-red-500 text-white px-6 py-2.5 rounded-xl font-extrabold shadow-md text-sm">Kirim Penolakan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="reviewBeritaModal" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-4xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50 shrink-0">
                <h3 class="text-xl font-extrabold text-slate-800">Tinjauan Artikel Jurnalistik</h3>
                <button onclick="closeReviewBeritaModal()" class="text-slate-400 hover:text-red-500 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            
            <div class="p-8 overflow-y-auto custom-scrollbar flex-1 bg-white">
                <img id="modal-berita-foto" src="" class="w-full h-64 md:h-80 object-cover rounded-2xl mb-6 bg-slate-100 shadow-inner">
                <div class="flex items-center gap-3 mb-4">
                    <span id="modal-berita-kategori" class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-lg text-xs font-extrabold uppercase tracking-widest"></span>
                    <span class="text-xs font-bold text-slate-400" id="modal-berita-info"></span>
                </div>
                <h1 id="modal-berita-judul" class="text-2xl md:text-3xl font-black text-slate-900 mb-6 leading-tight"></h1>
                <p id="modal-berita-lead" class="text-base md:text-lg font-semibold text-slate-700 mb-6 leading-relaxed border-l-4 border-indigo-500 pl-4"></p>
                <div id="modal-berita-body" class="text-sm text-slate-600 leading-loose space-y-4 mb-6 whitespace-pre-line"></div>
                <p id="modal-berita-closing" class="text-sm font-medium text-slate-500 italic bg-slate-50 p-4 rounded-xl border border-slate-100"></p>
            </div>

            <div class="p-6 border-t border-slate-100 bg-slate-50 shrink-0 flex flex-col gap-4">
                <form id="formReviewBerita" method="POST" action="" class="w-full">
                    @csrf @method('PATCH')
                    
                    <div id="alasanTolakContainer" class="hidden mb-4">
                        <label class="block text-xs font-extrabold text-red-500 uppercase tracking-widest mb-2">Alasan Penolakan (Wajib jika menolak):</label>
                        <textarea name="alasan_penolakan" id="inputAlasanTolak" rows="2" class="w-full bg-white border border-red-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-red-500 outline-none" placeholder="Tuliskan alasan spesifik agar Admin bisa merevisinya..."></textarea>
                    </div>

                    <div class="flex flex-col md:flex-row justify-end gap-3 w-full" id="areaTombolAksi">
                        <input type="hidden" name="status" id="inputStatusBerita" value="">
                        <button type="button" onclick="toggleAlasanTolak()" id="btnToggleTolak" class="bg-red-100 hover:bg-red-200 text-red-700 px-6 py-3 rounded-xl font-bold transition order-2 md:order-1 w-full md:w-auto">Tolak Artikel</button>
                        <button type="button" onclick="submitReview('rejected')" id="btnSubmitTolak" class="hidden bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition order-2 md:order-1 w-full md:w-auto">Kirim Penolakan</button>
                        <button type="button" onclick="submitReview('approved')" id="btnApproveBerita" class="bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg transition flex items-center justify-center gap-2 order-1 md:order-2 w-full md:w-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Setujui & Publikasikan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function switchMenu(menuName) {
            // Berita sudah dimasukkan ke dalam daftar array
            const sections = ['manajemen', 'tinjauan', 'rekap_jadwal', 'log', 'berita'];
            
            sections.forEach(section => {
                const sectionEl = document.getElementById('section-' + section);
                const buttonEl = document.getElementById('btn-' + section);
                
                if (!sectionEl || !buttonEl) return;

                if (section === menuName) {
                    sectionEl.classList.remove('hidden');
                    buttonEl.className = "w-full text-left px-4 py-3 bg-indigo-800 rounded-xl text-white font-bold shadow-lg shadow-indigo-900/50 transition";
                } else {
                    sectionEl.classList.add('hidden');
                    buttonEl.className = "w-full text-left px-4 py-3 rounded-xl text-indigo-300 hover:bg-indigo-800 hover:text-white transition font-medium";
                }
            });

            const headerTitle = document.getElementById('header-title');
            const headerDesc = document.getElementById('header-desc');
            
            if (headerTitle && headerDesc) {
                // Menambahkan deskripsi meta untuk Menu Berita
                const metadata = {
                    'manajemen': ["Manajemen Akses & Kebijakan", "Kelola Admin dan tinjau seluruh draf kebijakan dari satu pintu."],
                    'tinjauan': ["Tinjauan Draf Kebijakan", "Daftar permohonan publikasi draf yang menunggu persetujuan Anda."],
                    'rekap_jadwal': ["Rekap Jadwal Pertemuan", "Pantau seluruh janji temu yang telah disetujui oleh tim operasional."],
                    'log': ["Log Aktivitas Persetujuan", "Pantau seluruh riwayat audit keputusan secara realtime."],
                    'berita': ["Tinjauan Artikel Jurnalistik", "Review dan kelola draf berita yang diajukan oleh Admin operasional."]
                };

                if (metadata[menuName]) {
                    headerTitle.innerText = metadata[menuName][0];
                    headerDesc.innerText = metadata[menuName][1];
                }
            }
        }

        // Script Modals Kebijakan
        function openSetujuModal(id, kategori) {
            const modal = document.getElementById('setujuModal');
            const form = document.getElementById('formSetuju');
            if (modal && form) {
                modal.classList.replace('hidden', 'flex');
                form.action = `/super-admin/kebijakan/review/${kategori}/${id}`;
            }
        }
        function openTolakModal(id, kategori) {
            const modal = document.getElementById('tolakModal');
            const form = document.getElementById('formTolak');
            if (modal && form) {
                modal.classList.replace('hidden', 'flex');
                form.action = `/super-admin/kebijakan/review/${kategori}/${id}`;
            }
        }
        function closeKebijakanModals() {
            const sm = document.getElementById('setujuModal');
            const tm = document.getElementById('tolakModal');
            if (sm) sm.classList.replace('flex', 'hidden');
            if (tm) tm.classList.replace('flex', 'hidden');
        }

        // Script Modals Review Berita
        function openReviewBeritaModal(id) {
            document.getElementById('modal-berita-foto').src = document.getElementById('berita-foto-'+id).innerText;
            document.getElementById('modal-berita-kategori').innerText = document.getElementById('berita-kategori-'+id).innerText;
            document.getElementById('modal-berita-judul').innerText = document.getElementById('berita-judul-'+id).innerText;
            
            let lokasi = document.getElementById('berita-lokasi-'+id).innerText;
            let tanggal = document.getElementById('berita-tanggal-'+id).innerText;
            document.getElementById('modal-berita-info').innerText = tanggal + ' • ' + lokasi;

            document.getElementById('modal-berita-lead').innerText = document.getElementById('berita-lead-'+id).innerText;
            document.getElementById('modal-berita-body').innerText = document.getElementById('berita-body-'+id).innerText;
            
            let closing = document.getElementById('berita-closing-'+id).innerText;
            let elClosing = document.getElementById('modal-berita-closing');
            if(closing.trim() !== "") {
                elClosing.classList.remove('hidden');
                elClosing.innerText = closing;
            } else {
                elClosing.classList.add('hidden');
            }

            document.getElementById('formReviewBerita').action = `/super-admin/berita/review/${id}`;
            
            let isPending = !document.getElementById('areaTombolAksi') || document.getElementById('btnToggleTolak').classList.contains('hidden') === false; 
            
            document.getElementById('alasanTolakContainer').classList.add('hidden');
            document.getElementById('btnSubmitTolak').classList.add('hidden');
            document.getElementById('inputAlasanTolak').value = "";
            document.getElementById('inputAlasanTolak').required = false;

            // Jika status berita di HTML ada tombol 'Review Artikel', maka statusnya masih pending.
            if(document.getElementById('formReviewBerita').parentElement.querySelector('#areaTombolAksi')) {
                document.getElementById('areaTombolAksi').classList.remove('hidden');
                document.getElementById('btnToggleTolak').classList.remove('hidden');
                document.getElementById('btnApproveBerita').classList.remove('hidden');
            }

            document.getElementById('reviewBeritaModal').classList.replace('hidden', 'flex');
        }

        function closeReviewBeritaModal() {
            document.getElementById('reviewBeritaModal').classList.replace('flex', 'hidden');
        }

        function toggleAlasanTolak() {
            document.getElementById('alasanTolakContainer').classList.remove('hidden');
            document.getElementById('btnToggleTolak').classList.add('hidden');
            document.getElementById('btnApproveBerita').classList.add('hidden');
            document.getElementById('btnSubmitTolak').classList.remove('hidden');
            document.getElementById('inputAlasanTolak').required = true;
        }

        function submitReview(status) {
            document.getElementById('inputStatusBerita').value = status;
            document.getElementById('formReviewBerita').submit();
        }
    </script>
</body>
</html>