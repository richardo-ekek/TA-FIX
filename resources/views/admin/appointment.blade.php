<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - Pusat Komando SPA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800 min-h-screen flex">

    <aside class="w-72 bg-slate-900 text-slate-300 flex flex-col shadow-2xl z-20 hidden md:flex">
        <div class="p-6 border-b border-slate-800 flex items-center gap-3">
            <div class="bg-blue-500 text-white p-2 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <h1 class="text-white font-bold text-lg leading-tight">Panel Admin</h1>
                <p class="text-xs text-slate-500">{{ auth()->user() ? ucfirst(explode('@', auth()->user()->email)[0]) : 'Admin' }}</p>
            </div>
        </div>
        
        <nav class="flex-1 p-4 space-y-2">
            <button type="button" onclick="switchMenuAdmin('appointment')" id="btn-appointment" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/50 font-bold transition">Kelola Appointment</button>
            <button type="button" onclick="switchMenuAdmin('rekap_jadwal')" id="btn-rekap_jadwal" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition text-slate-300 hover:text-white text-sm font-medium">Rekap Jadwal</button>
            <button type="button" onclick="switchMenuAdmin('kebijakan')" id="btn-kebijakan" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition text-slate-300 hover:text-white text-sm font-medium">Kelola Kebijakan & Dokumen</button>
            <button type="button" onclick="switchMenuAdmin('berita')" id="btn-berita" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition text-slate-300 hover:text-white text-sm font-medium">Portal Berita</button>
        </nav>

        <div class="p-4 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="flex justify-center items-center gap-2 w-full bg-slate-800 hover:bg-red-500/20 hover:text-red-400 py-3 rounded-xl text-sm font-bold transition">Logout</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <header class="bg-white px-8 py-5 border-b border-slate-200 shadow-sm flex justify-between items-center z-10">
            <div>
                <h2 id="header-title" class="text-2xl font-extrabold text-slate-800">Antrean Appointment</h2>
                <p id="header-desc" class="text-sm text-slate-500 mt-1">Tinjau dan proses permohonan janji temu dari instansi/user.</p>
            </div>
            <button type="button" onclick="openRadar()" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2 transition border border-indigo-200">
                🌐 Radar Berita Global
            </button>
        </header>

        <div class="flex-1 p-8 overflow-y-auto bg-slate-50 custom-scrollbar">
            
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl font-semibold shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div id="section-appointment">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <table class="min-w-full text-left whitespace-nowrap">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr><th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Tanggal & Instansi</th><th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Tujuan</th><th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Mode</th><th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Status</th><th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-right">Aksi</th></tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($appointments ?? [] as $appt)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Diajukan: {{ $appt->created_at->format('d M Y') }}</p>
                                        <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-2 mt-1"><span class="block text-[10px] font-extrabold text-indigo-500 uppercase">Preferensi Waktu:</span><span class="text-xs font-bold text-indigo-700">{{ $appt->preferensi_waktu ? \Carbon\Carbon::parse($appt->preferensi_waktu)->format('d M Y, H:i') : 'Tanpa Preferensi' }}</span></div>
                                    </td>
                                    <td class="px-6 py-4"><p class="font-bold text-slate-800 text-sm">{{ $appt->instansi }}</p><p class="text-xs font-medium text-slate-500">{{ $appt->nama }}</p><p class="text-[11px] text-indigo-600 mt-1 font-semibold italic">{{ Str::limit($appt->tujuan, 30) }}</p></td>
                                    <td class="px-6 py-4 capitalize text-sm font-semibold text-slate-600">{{ $appt->mode }}</td>
                                    <td class="px-6 py-4">
                                        @if($appt->status == 'submitted') <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold uppercase">Submitted</span>
                                        @elseif($appt->status == 'approved') <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold uppercase">Approved</span>
                                        @else <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold uppercase">Rejected</span> @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if($appt->status == 'submitted')
                                            <div class="flex justify-end gap-2">
                                                <div id="rahasia-instansi-{{ $appt->id }}" class="hidden">{{ $appt->instansi }}</div><div id="rahasia-alamat-{{ $appt->id }}" class="hidden">{{ $appt->alamat }}</div><div id="rahasia-detail-{{ $appt->id }}" class="hidden">{{ $appt->detail_tujuan }}</div><div id="rahasia-waktu-{{ $appt->id }}" class="hidden">{{ $appt->preferensi_waktu ? \Carbon\Carbon::parse($appt->preferensi_waktu)->format('d M Y, H:i') : 'Tidak ada preferensi' }}</div>
                                                <button onclick="openDetailModal('{{ $appt->id }}')" class="bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg text-sm font-bold">Detail</button><button onclick="openApproveModal('{{ $appt->id }}', '{{ $appt->mode }}')" class="bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-lg text-sm font-bold">Setujui</button><button onclick="openRejectModal('{{ $appt->id }}')" class="bg-red-50 text-red-600 px-3 py-1.5 rounded-lg text-sm font-bold">Tolak</button>
                                            </div>
                                        @else <span class="text-xs font-bold text-slate-400">Telah Diproses</span> @endif
                                    </td>
                                </tr>
                            @empty <tr><td colspan="5" class="px-6 py-10 text-center text-slate-500 italic">Tidak ada antrean saat ini.</td></tr> @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="section-rekap_jadwal" class="hidden">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead><tr class="bg-slate-50 text-slate-400 text-xs uppercase border-b border-slate-200"><th class="px-6 py-5 font-extrabold">Waktu Pertemuan</th><th class="px-6 py-5 font-extrabold">Instansi / Pemohon</th><th class="px-6 py-5 font-extrabold">Tujuan & Mode</th><th class="px-6 py-5 font-extrabold text-center">Status Jadwal</th></tr></thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($jadwals ?? [] as $jadwal)
                                @php
                                    $waktuJadwal = \Carbon\Carbon::parse($jadwal->tanggal_waktu_pertemuan)->startOfDay();
                                    $hariIni = \Carbon\Carbon::now()->startOfDay();
                                    $selisihHari = $hariIni->diffInDays($waktuJadwal, false); 
                                    if ($selisihHari < 0) { $warna = 'bg-slate-100 text-slate-500 border-slate-200'; $teks = 'Telah Berlalu'; } 
                                    elseif ($selisihHari <= 2) { $warna = 'bg-red-100 text-red-700 border-red-200 animate-pulse'; $teks = 'H-' . $selisihHari . ' (Segera)'; } 
                                    elseif ($selisihHari <= 5) { $warna = 'bg-amber-100 text-amber-700 border-amber-200'; $teks = 'H-' . $selisihHari . ' (Mendekati)'; } 
                                    else { $warna = 'bg-emerald-100 text-emerald-700 border-emerald-200'; $teks = 'H-' . $selisihHari . ' (Aman)'; }
                                    if ($selisihHari == 0) { $warna = 'bg-red-600 text-white animate-pulse border-red-600'; $teks = 'HARI INI!'; }
                                @endphp
                                <tr class="hover:bg-slate-50/80">
                                    <td class="px-6 py-5"><div class="font-extrabold text-slate-900 text-sm">{{ \Carbon\Carbon::parse($jadwal->tanggal_waktu_pertemuan)->format('d M Y') }}</div><div class="text-[10px] font-bold text-indigo-600 mt-1 bg-indigo-50 inline-block px-2 py-0.5 rounded">{{ \Carbon\Carbon::parse($jadwal->tanggal_waktu_pertemuan)->format('H:i') }} WIB</div></td>
                                    <td class="px-6 py-5"><div class="font-extrabold text-slate-900 text-sm">{{ $jadwal->instansi ?? 'N/A' }}</div><div class="text-[10px] font-medium text-slate-500 mt-0.5">{{ $jadwal->nama ?? 'User Unknown' }}</div></td>
                                    <td class="px-6 py-5"><div class="text-xs font-bold text-slate-800">{{ Str::limit($jadwal->tujuan, 30) }}</div><div class="text-[10px] font-extrabold text-slate-500 mt-1 bg-slate-100 px-2 py-0.5 rounded w-fit uppercase">{{ $jadwal->mode }}</div></td>
                                    <td class="px-6 py-5 text-center"><span class="inline-block px-3 py-1.5 rounded-lg text-[10px] font-extrabold tracking-wider border {{ $warna }}">{{ $teks }}</span></td>
                                </tr>
                            @empty <tr><td colspan="4" class="px-6 py-12 text-center text-slate-400 italic">Belum ada jadwal yang disetujui.</td></tr> @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="section-kebijakan" class="hidden grid grid-cols-1 xl:grid-cols-2 gap-8 items-start">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
                    <div class="flex border-b border-slate-200 bg-slate-50 text-sm font-bold">
                        <button type="button" onclick="switchTab('tab-mou')" id="btn-mou" class="flex-1 py-4 text-indigo-700 border-b-2 border-indigo-600 bg-white transition">MoU / PKS</button>
                        <button type="button" onclick="switchTab('tab-tik')" id="btn-tik" class="flex-1 py-4 text-slate-500 hover:text-slate-800 transition">TIK Kemlu</button>
                        <button type="button" onclick="switchTab('tab-non')" id="btn-non" class="flex-1 py-4 text-slate-500 hover:text-slate-800 transition">TIK Non-Kemlu</button>
                    </div>
                    <div class="p-6">
                        <form id="tab-mou" action="{{ route('admin.mou.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-2 gap-4">
                                <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Jenis</label><select name="jenis" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"><option value="MoU">MoU</option><option value="PKS">PKS</option></select></div>
                                <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Status</label><select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"><option value="pending">Dalam Proses</option><option value="aktif">Aktif</option><option value="tidak aktif">Tidak Aktif</option></select></div>
                            </div>
                            <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Perihal Dokumen</label><input type="text" name="perihal" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            <div class="grid grid-cols-2 gap-4">
                                <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Satker Kemlu</label><input type="text" name="satker_kemlu" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                                <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">K/L/I External</label><input type="text" name="instansi_external" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                                <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Tgl Disahkan</label><input type="date" name="tanggal_disahkan" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                                <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Tgl Berakhir</label><input type="date" name="tanggal_berakhir" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            </div>
                            <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Keterangan</label><textarea name="keterangan" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm resize-none"></textarea></div>
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl transition shadow-lg">Simpan MoU/PKS</button>
                        </form>

                        <form id="tab-tik" action="{{ route('admin.tik_kemlu.store') }}" method="POST" class="space-y-4 hidden">
                            @csrf
                            <div class="grid grid-cols-2 gap-4">
                                <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Jenis Kebijakan</label><input type="text" name="jenis_kebijakan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                                <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nomor Kebijakan</label><input type="text" name="nomor_kebijakan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            </div>
                            <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Tahun Penerbitan</label><input type="number" name="tahun" min="1900" max="9999" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Perihal Kebijakan</label><input type="text" name="perihal" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Tautan (Link)</label><input type="url" name="tautan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition shadow-lg">Simpan TIK Kemlu</button>
                        </form>

                        <form id="tab-non" action="{{ route('admin.tik_non_kemlu.store') }}" method="POST" class="space-y-4 hidden">
                            @csrf
                            <div class="grid grid-cols-2 gap-4">
                                <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Jenis Kebijakan</label><input type="text" name="jenis_kebijakan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                                <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nomor Kebijakan</label><input type="text" name="nomor_kebijakan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            </div>
                            <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Instansi</label><input type="text" name="instansi" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Tahun Penerbitan</label><input type="number" name="tahun" min="1900" max="9999" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Perihal Kebijakan</label><input type="text" name="perihal" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Tautan (Link)</label><input type="url" name="tautan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-4 rounded-xl transition shadow-lg">Simpan TIK Non-Kemlu</button>
                        </form>
                    </div>
                </div>

                <div class="space-y-4 h-[750px] flex flex-col">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">Riwayat Pengajuan & Status <span class="bg-indigo-100 text-indigo-600 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $allKebijakan->count() }}</span></h3>
                    <div class="flex-1 overflow-y-auto space-y-4 pr-2 custom-scrollbar">
                        @forelse($allKebijakan ?? [] as $item)
                            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 relative overflow-hidden transition hover:border-indigo-300">
                                <div class="flex justify-between items-start mb-2">
                                    <div><span class="bg-slate-100 text-slate-700 px-2 py-1 rounded text-[10px] font-extrabold uppercase tracking-widest border border-slate-200">{{ $item->tipe_dokumen }}</span><span class="text-[11px] text-slate-400 font-bold ml-2">{{ $item->created_at->format('d M Y, H:i') }}</span></div>
                                    @if($item->status == 'pending' || $item->status == 'dalam proses') <span class="bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-widest">Menunggu</span>
                                    @elseif($item->status == 'approved' || $item->status == 'aktif') <span class="bg-emerald-100 text-emerald-700 px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-widest">Disetujui</span>
                                    @elseif($item->status == 'rejected' || $item->status == 'tidak aktif') <span class="bg-red-100 text-red-700 px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-widest">Ditolak</span> @endif
                                </div>
                                <h4 class="font-bold text-slate-800 text-base leading-tight">{{ $item->judul }}</h4>
                                @if(isset($item->nomor_kebijakan)) <p class="text-xs text-slate-500 mt-1 font-mono">No: {{ $item->nomor_kebijakan }}</p> @endif
                                @if(($item->status == 'approved' || $item->status == 'aktif') && $item->keterangan_tambahan)
                                    <div class="bg-emerald-50/50 border border-emerald-100 p-3 rounded-xl text-sm text-emerald-800 mt-3 flex gap-2"><svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg><div><span class="font-bold block text-[10px] uppercase tracking-wider mb-0.5 text-emerald-600">Catatan:</span>{{ $item->keterangan_tambahan }}</div></div>
                                @elseif(($item->status == 'rejected' || $item->status == 'tidak aktif') && $item->alasan_penolakan)
                                    <div class="bg-red-50/50 border border-red-100 p-3 rounded-xl text-sm text-red-800 mt-3 flex gap-2"><svg class="w-4 h-4 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg><div><span class="font-bold block text-[10px] uppercase tracking-wider mb-0.5 text-red-600">Alasan Penolakan:</span>{{ $item->alasan_penolakan }}</div></div>
                                @endif
                            </div>
                        @empty <div class="bg-slate-50 rounded-2xl border border-slate-100 p-8 text-center text-slate-500 font-medium italic">Belum ada dokumen yang diajukan.</div> @endforelse
                    </div>
                </div>
            </div>

            <div id="section-berita" class="hidden grid-cols-1 xl:grid-cols-12 gap-8 items-start">
                
                <div class="xl:col-span-7 bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6">
                        <h3 class="text-xl font-extrabold text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            Tulis Berita Baru
                        </h3>
                    </div>
                    
                    <div class="p-8">
                        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                            @csrf
                            <div class="grid grid-cols-2 gap-5">
                                <div><label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-2">Kategori Berita</label>
                                    <select name="kategori" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                        <option value="Dalam Negeri">Berita Dalam Negeri</option><option value="Mancanegara">Berita Mancanegara</option><option value="Kerjasama">Berita Kerjasama</option>
                                    </select>
                                </div>
                                <div><label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-2">Foto / Gambar (Max 2MB)</label>
                                    <input type="file" name="foto" accept="image/*" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>
                            </div>

                            <div><label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-2">Judul Headline</label>
                                <input type="text" name="judul" required placeholder="Tulis judul yang menarik..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>

                            <div class="grid grid-cols-2 gap-5">
                                <div><label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-2">Tanggal Liputan</label>
                                    <input type="date" name="tanggal" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                </div>
                                <div><label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-2">Lokasi (Kota/Negara)</label>
                                    <input type="text" name="lokasi" required placeholder="Contoh: Jakarta, Indonesia" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between items-end mb-2">
                                    <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">Body (Isi Berita Lengkap)</label>
                                    <button type="button" onclick="actionTranslate()" id="btnTrans" class="bg-blue-50 text-blue-600 px-3 py-1 rounded-lg text-[10px] font-bold hover:bg-blue-600 hover:text-white transition flex items-center gap-1">
                                        ✨ Terjemahkan ke ID (Groq AI)
                                    </button>
                                </div>
                                <textarea name="body" id="inputBodyBerita" required rows="6" placeholder="Tuliskan isi berita atau paste rilis pers berbahasa asing di sini..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-y"></textarea>
                            </div>

                            <div>
                                <div class="flex justify-between items-end mb-2 mt-4">
                                    <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">Lead (Paragraf Pembuka)</label>
                                    <button type="button" onclick="actionGenerateLead()" id="btnLead" class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-lg text-[10px] font-bold hover:bg-indigo-600 hover:text-white transition flex items-center gap-1">
                                        🤖 Buat Lead Otomatis (Groq AI)
                                    </button>
                                </div>
                                <textarea name="lead" id="inputLeadBerita" required rows="2" placeholder="Ringkasan singkat isi berita..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
                            </div>

                            <div><label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-2">Closing (Paragraf Penutup - Opsional)</label>
                                <textarea name="closing" rows="2" placeholder="Kesimpulan atau penutup berita..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
                            </div>

                            <div class="pt-4 border-t border-slate-100">
                                <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-extrabold py-4 rounded-xl shadow-lg transition flex justify-center items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    Unggah Draf ke Super Admin
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="xl:col-span-5 space-y-4 h-[900px] flex flex-col">
                    <h3 class="text-xl font-extrabold text-slate-800 flex items-center gap-2">
                        <div class="bg-orange-100 text-orange-600 p-2 rounded-xl"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        Status Draf Berita Anda
                    </h3>
                    
                    <div class="flex-1 overflow-y-auto space-y-4 pr-2 custom-scrollbar">
                        @forelse($riwayatBerita ?? [] as $berita)
                            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 relative overflow-hidden transition hover:border-blue-300 group">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-widest">{{ $berita->kategori }}</span>
                                    </div>
                                    @if($berita->status == 'pending') <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest animate-pulse">Ditinjau</span>
                                    @elseif($berita->status == 'approved') <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest">Dipublikasi</span>
                                    @else <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest">Ditolak</span> @endif
                                </div>
                                
                                <h4 class="font-bold text-slate-800 text-base leading-snug mb-2">{{ $berita->judul }}</h4>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ \Carbon\Carbon::parse($berita->tanggal)->format('d M Y') }} • {{ $berita->lokasi }}</p>
                                
                                @if($berita->status == 'rejected' && $berita->alasan_penolakan)
                                    <div class="mt-4 bg-red-50/50 border border-red-100 rounded-xl p-3 flex gap-3 items-start">
                                        <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <div>
                                            <span class="block text-[10px] font-extrabold text-red-600 uppercase tracking-widest mb-1">Catatan Penolakan:</span>
                                            <p class="text-xs text-red-800 italic leading-relaxed">{{ $berita->alasan_penolakan }}</p>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($berita->foto)
                                    <div class="mt-4 h-24 w-full rounded-xl overflow-hidden bg-slate-100 opacity-70 group-hover:opacity-100 transition">
                                        <img src="{{ asset('storage/' . $berita->foto) }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="bg-transparent border-2 border-dashed border-slate-200 rounded-[2rem] p-10 text-center flex flex-col items-center justify-center text-slate-400">
                                <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                <span class="font-bold text-sm">Belum ada berita yang ditulis.</span>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </main>

    <div id="detailModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 flex justify-between items-center shrink-0">
                <div class="flex items-center gap-4 text-white">
                    <div class="bg-white/20 p-3 rounded-2xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                    <div><h3 class="text-xl font-extrabold">Detail Pengajuan Form</h3><p class="text-blue-100 text-sm">Informasi lengkap dari User</p></div>
                </div>
                <button type="button" onclick="closeModals()" class="text-white/70 hover:text-white bg-white/10 p-2 rounded-full transition hover:bg-white/20"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <div class="p-6 overflow-y-auto space-y-6 bg-slate-50/50">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 flex gap-4"><div class="bg-blue-50 p-2.5 rounded-xl text-blue-600 shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m3-4h1m-1 4h1m-5 8h8"></path></svg></div><div><span class="block text-[10px] font-extrabold text-slate-400 uppercase">Instansi Asal</span><span id="mdl-instansi" class="block text-sm font-bold text-slate-800 italic"></span></div></div>
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 flex gap-4"><div class="bg-orange-50 p-2.5 rounded-xl text-orange-600 shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div><div><span class="block text-[10px] font-extrabold text-slate-400 uppercase">Preferensi Waktu</span><span id="mdl-waktu" class="block text-sm font-bold text-slate-800"></span></div></div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-100"><span class="flex items-center gap-2 text-[10px] font-extrabold text-slate-400 uppercase mb-2">Alamat Lengkap Instansi</span><span id="mdl-alamat" class="block text-sm font-semibold text-slate-700 italic"></span></div>
                <div><span class="block text-[10px] font-extrabold text-slate-400 uppercase mb-2 pl-1">Detail Tujuan Pembahasan</span><div id="mdl-detail" class="bg-indigo-50/50 p-6 rounded-2xl border border-indigo-100/50 text-sm text-slate-700 min-h-[120px] whitespace-pre-wrap font-medium shadow-inner"></div></div>
            </div>
            <div class="p-6 border-t bg-white flex justify-end"><button type="button" onclick="closeModals()" class="bg-slate-800 hover:bg-slate-900 text-white px-8 py-3 rounded-xl text-sm font-bold shadow-lg transition">Tutup Jendela</button></div>
        </div>
    </div>

    <div id="approveModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-6 border border-slate-100">
            <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2"><svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Setujui & Jadwalkan Pertemuan</h3>
            <form id="approveForm" method="POST" action="" class="space-y-4">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="approved">
                <div><label class="block text-sm font-bold text-slate-700 mb-1 italic">Jadwal Fix Pertemuan</label><input type="datetime-local" name="tanggal_waktu_pertemuan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-emerald-500 outline-none"></div>
                <div id="daringFields" class="hidden space-y-4 border-t border-dashed pt-4 mt-4"><div><label class="block text-sm font-bold text-slate-700 mb-1">Link Video Conference</label><input type="url" name="link_meeting" placeholder="https://zoom.us/j/..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div></div>
                <div id="luringFields" class="hidden space-y-4 border-t border-dashed pt-4 mt-4"><div><label class="block text-sm font-bold text-slate-700 mb-1">Alamat Gedung/Instansi</label><input type="text" name="alamat_pertemuan" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div><div><label class="block text-sm font-bold text-slate-700 mb-1 italic">Link Google Maps (Opsional)</label><input type="url" name="link_maps" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div></div>
                <div class="border-t pt-4 mt-4"><label class="block text-sm font-bold text-slate-700 mb-1">Keterangan Tambahan</label><textarea name="keterangan_tambahan" rows="2" placeholder="Contoh: Silakan bawa surat pengantar." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm resize-none"></textarea></div>
                <div class="pt-4 flex justify-end gap-3"><button type="button" onclick="closeModals()" class="px-4 py-2 font-bold text-slate-500 hover:text-slate-700 transition">Batal</button><button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2 rounded-xl font-bold shadow-lg transition">Kirim Persetujuan</button></div>
            </form>
        </div>
    </div>

    <div id="rejectModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-6 border border-red-50">
            <h3 class="text-xl font-bold text-red-600 mb-4 flex items-center gap-2"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg> Tolak Permohonan</h3>
            <form id="rejectForm" method="POST" action="" class="space-y-4">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="rejected">
                <div><label class="block text-sm font-bold text-slate-700 mb-1">Alasan Penolakan</label><textarea name="alasan_penolakan" required rows="4" placeholder="Sebutkan alasan penolakan secara jelas..." class="w-full bg-red-50/50 border border-red-200 rounded-xl p-3 text-sm resize-none focus:ring-2 focus:ring-red-500 outline-none"></textarea></div>
                <div class="pt-4 flex justify-end gap-3"><button type="button" onclick="closeModals()" class="px-4 py-2 font-bold text-slate-500">Batal</button><button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-xl font-bold shadow-lg transition">Kirim Penolakan</button></div>
            </form>
        </div>
    </div>

    <div id="radarModal" class="fixed inset-0 bg-slate-900/60 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-4xl p-8 flex flex-col max-h-[90vh]">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-black text-slate-800 flex items-center gap-2">🌍 Radar Berita Internasional</h3>
                <button onclick="closeRadar()" class="text-slate-400 hover:text-red-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            
            <div class="mb-6 flex gap-3">
                <input type="text" id="inputCariRadar" placeholder="Ketik topik berita (Contoh: ASEAN, Ekonomi Global, Konflik)..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500 outline-none" onkeypress="if(event.key === 'Enter') openRadar()">
                <button type="button" onclick="openRadar()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition whitespace-nowrap">
                    Cari Berita
                </button>
            </div>

            <div id="radarContent" class="overflow-y-auto space-y-4 custom-scrollbar pr-2 flex-1">
                <p class="text-center italic text-slate-400">Sedang menyapu berita global...</p>
            </div>
        </div>
    </div>

    <script>
        // TOKEN CSRF GLOBAL
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // ==================== MENU SWITCH ====================
        function switchMenuAdmin(menuName) {
            const sections = ['appointment', 'rekap_jadwal', 'kebijakan', 'berita'];
            const titles = {
                'appointment': ['Antrean Appointment', 'Tinjau dan proses permohonan janji temu dari instansi/user.'],
                'rekap_jadwal': ['Rekap Jadwal Pertemuan', 'Daftar seluruh janji temu yang telah disetujui.'],
                'kebijakan': ['Manajemen Kebijakan', 'Input draf kebijakan TIK atau dokumen kerja sama.'],
                'berita': ['Kelola Portal Berita', 'Tulis dan ajukan draf berita untuk ditinjau oleh Super Admin.']
            };

            sections.forEach(section => {
                const el = document.getElementById('section-' + section);
                const btn = document.getElementById('btn-' + section);
                if(!el || !btn) return;

                if (section === menuName) {
                    el.classList.remove('hidden');
                    if(section === 'kebijakan' || section === 'berita') el.classList.add('grid');
                    btn.className = "w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg font-bold transition";
                } else {
                    el.classList.add('hidden');
                    el.classList.remove('grid');
                    btn.className = "w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition text-slate-300 hover:text-white text-sm font-medium";
                }
            });

            document.getElementById('header-title').innerText = titles[menuName][0];
            document.getElementById('header-desc').innerText = titles[menuName][1];
        }

        function switchTab(tabId) {
            document.getElementById('tab-mou').classList.add('hidden');
            document.getElementById('tab-tik').classList.add('hidden');
            document.getElementById('tab-non').classList.add('hidden');
            
            ['btn-mou', 'btn-tik', 'btn-non'].forEach(id => {
                document.getElementById(id).className = 'flex-1 py-4 text-slate-500 hover:text-slate-800 transition';
            });

            document.getElementById(tabId).classList.remove('hidden');
            let activeBtn = document.getElementById(tabId.replace('tab', 'btn'));
            activeBtn.className = 'flex-1 py-4 text-indigo-700 border-b-2 border-indigo-600 bg-white font-bold transition';
        }

        // ==================== MODALS ====================
        function openDetailModal(id) {
            const instansi = document.getElementById('rahasia-instansi-' + id).innerText;
            const alamat = document.getElementById('rahasia-alamat-' + id).innerText;
            const detail = document.getElementById('rahasia-detail-' + id).innerText;
            const waktu = document.getElementById('rahasia-waktu-' + id).innerText;

            document.getElementById('mdl-instansi').innerText = instansi;
            document.getElementById('mdl-alamat').innerText = alamat;
            document.getElementById('mdl-detail').innerText = detail;
            document.getElementById('mdl-waktu').innerText = waktu;

            document.getElementById('detailModal').classList.replace('hidden', 'flex');
        }

        function openApproveModal(id, mode) {
            document.getElementById('approveModal').classList.replace('hidden', 'flex');
            document.getElementById('approveForm').action = `/admin/appointment/${id}/status`;
            
            if (mode.toLowerCase() === 'daring') {
                document.getElementById('daringFields').classList.remove('hidden');
                document.getElementById('luringFields').classList.add('hidden');
            } else {
                document.getElementById('daringFields').classList.add('hidden');
                document.getElementById('luringFields').classList.remove('hidden');
            }
        }

        function openRejectModal(id) {
            document.getElementById('rejectModal').classList.replace('hidden', 'flex');
            document.getElementById('rejectForm').action = `/admin/appointment/${id}/status`;
        }

        function closeModals() {
            document.getElementById('approveModal').classList.replace('flex', 'hidden');
            document.getElementById('rejectModal').classList.replace('flex', 'hidden');
            document.getElementById('detailModal').classList.replace('flex', 'hidden');
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('fixed')) closeModals();
        }

        // ==================== FITUR AI GROQ ====================

        // 1. Fungsi Terjemahan AI
        async function actionTranslate() {
            const bodyEl = document.getElementById('inputBodyBerita');
            if(!bodyEl.value) return alert('Silakan isi kolom Body terlebih dahulu untuk diterjemahkan!');
            
            const btn = document.getElementById('btnTrans');
            btn.innerText = 'AI Sedang Menerjemahkan...';
            btn.disabled = true;

            try {
                const req = await fetch('/admin/api/berita/translate', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ text: bodyEl.value })
                });
                const res = await req.json();
                if(res.translated_text) { bodyEl.value = res.translated_text; }
                else { alert('Gagal: ' + (res.error || 'Terjadi kesalahan pada AI')); }
            } catch (e) { alert('Terjadi kesalahan jaringan.'); }
            
            btn.innerText = '✨ Terjemahkan ke ID (Groq AI)';
            btn.disabled = false;
        }

        // 2. Fungsi Ekstrak Lead AI
        async function actionGenerateLead() {
            const bodyEl = document.getElementById('inputBodyBerita');
            const leadEl = document.getElementById('inputLeadBerita');
            if(!bodyEl.value) return alert('AI membutuhkan teks di kolom Body untuk dirangkum!');

            const btn = document.getElementById('btnLead');
            btn.innerText = 'AI Sedang Menulis...';
            btn.disabled = true;

            try {
                const req = await fetch('/admin/api/berita/generate-lead', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ body: bodyEl.value })
                });
                const res = await req.json();
                if(res.lead) { leadEl.value = res.lead; }
                else { alert('Gagal: ' + (res.error || 'Terjadi kesalahan pada AI')); }
            } catch (e) { alert('Terjadi kesalahan jaringan.'); }
            
            btn.innerText = '🤖 Buat Lead Otomatis (Groq AI)';
            btn.disabled = false;
        }

        // 3. Fungsi Buka Radar Berita Global (NewsData.io)
        async function openRadar() {
            document.getElementById('radarModal').classList.replace('hidden', 'flex');
            const container = document.getElementById('radarContent');
            
            const searchBox = document.getElementById('inputCariRadar');
            const keyword = searchBox ? searchBox.value.trim() : '';
            
            container.innerHTML = '<p class="text-center italic text-slate-400">🌐 Sedang menyapu berita global...</p>';
            
            try {
                const url = keyword ? `/admin/api/berita/radar-global?q=${encodeURIComponent(keyword)}` : '/admin/api/berita/radar-global';
                
                const response = await fetch(url);
                const data = await response.json();
                
                if (data.results && data.results.length > 0) {
                    let html = '';
                    data.results.forEach(news => {
                        html += `
                            <div class="p-5 border border-slate-100 rounded-2xl hover:bg-slate-50 transition shadow-sm bg-white">
                                <span class="text-[10px] font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2 py-1 rounded">${news.source_id || 'Media'}</span>
                                <h4 class="font-bold text-slate-800 text-base mt-2 mb-2">${news.title || 'Tanpa Judul'}</h4>
                                <p class="text-sm text-slate-500 line-clamp-2">${news.description || 'Tidak ada ringkasan tersedia.'}</p>
                                <a href="${news.link}" target="_blank" class="text-xs text-indigo-600 font-bold mt-3 inline-block underline">Baca Sumber Asli →</a>
                            </div>`;
                    });
                    container.innerHTML = html;
                } else {
                    container.innerHTML = '<p class="text-center text-slate-500">Tidak ada berita yang ditemukan untuk kata kunci tersebut.</p>';
                }
            } catch (error) { 
                container.innerHTML = '<p class="text-center text-red-500 italic">Gagal mengambil data berita global. Silakan coba lagi nanti.</p>'; 
            }
        }

        function closeRadar() { document.getElementById('radarModal').classList.replace('flex', 'hidden'); }
    </script>
</body>
</html>