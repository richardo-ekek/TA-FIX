<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - Pusat Komando SPA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800 min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-72 bg-slate-900 text-slate-300 flex flex-col shadow-2xl z-20 hidden md:flex">
        <div class="p-6 border-b border-slate-800 flex items-center gap-3">
            <div class="bg-blue-600 rounded-lg overflow-hidden w-10 h-10 flex items-center justify-center font-bold text-white">
                @if(auth()->user()->foto_profil)
                    <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" class="w-full h-full object-cover">
                @else
                    {{ substr(auth()->user()->name, 0, 1) }}
                @endif
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
            <button type="button" onclick="switchMenuAdmin('profil')" id="btn-profil" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition text-slate-300 hover:text-white text-sm font-medium">Profil & Keamanan</button>
        </nav>

        <div class="p-4 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="flex justify-center items-center gap-2 w-full bg-slate-800 hover:bg-red-500/20 hover:text-red-400 py-3 rounded-xl text-sm font-bold transition">Logout</button>
            </form>
        </div>
    </aside>

    <!-- KONTEN UTAMA -->
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

            <!-- SECTION PROFIL & GANTI PASSWORD -->
            <div id="section-profil" class="hidden">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8 max-w-3xl">
                    <h3 class="text-xl font-extrabold text-slate-800 mb-6">Identitas Akun & Foto</h3>
                    
                    <form action="{{ route('profile.update_foto') }}" method="POST" enctype="multipart/form-data" class="mb-8 flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        @csrf
                        <div class="shrink-0 w-16 h-16 rounded-full overflow-hidden bg-blue-100 border-2 border-white shadow-sm flex items-center justify-center text-xl font-bold text-blue-600">
                            @if(auth()->user()->foto_profil)
                                <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" class="w-full h-full object-cover">
                            @else
                                {{ substr(auth()->user()->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Pilih Foto (Max 2MB)</label>
                            <input type="file" name="foto_profil" required accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 transition">
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-xl transition shadow-md text-sm">Update Foto</button>
                    </form>

                    <div class="mb-8 grid grid-cols-2 gap-4 bg-slate-50 p-6 rounded-2xl border border-slate-100">
                        <div><span class="block text-[10px] font-bold text-slate-400 uppercase">Nama Terdaftar</span><span class="font-extrabold text-slate-800">{{ auth()->user()->name }}</span></div>
                        <div><span class="block text-[10px] font-bold text-slate-400 uppercase">Email Terdaftar</span><span class="font-extrabold text-slate-800">{{ auth()->user()->email }}</span></div>
                        <div class="col-span-2"><span class="block text-[10px] font-bold text-slate-400 uppercase">Hak Akses</span><span class="font-extrabold text-blue-600 uppercase">{{ auth()->user()->role }}</span></div>
                    </div>

                    <h3 class="text-xl font-extrabold text-slate-800 mb-6 border-t pt-6">Lengkapi Profil Pegawai</h3>
                    <form action="{{ route('profile.custom.update_detail') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none"></div>
                            
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nomor Induk Pegawai (NIP)</label>
                            <input type="text" name="nip" value="{{ auth()->user()->nip }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Masukkan NIP..."></div>
                            
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ auth()->user()->tanggal_lahir }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none"></div>
                            
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Status Jabatan</label>
                            <input type="text" name="jabatan" value="{{ auth()->user()->jabatan }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Contoh: Staf IT / Analis"></div>

                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nomor Telepon</label>
                            <input type="text" name="no_telp" value="{{ auth()->user()->no_telp }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="0812345..."></div>
                            
                            <div class="md:col-span-2"><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Alamat Rumah</label>
                            <textarea name="alamat" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">{{ auth()->user()->alamat }}</textarea></div>
                        </div>
                        <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 px-6 rounded-xl transition mt-2 shadow-md">Simpan Profil</button>
                    </form>

                    <h3 class="text-xl font-extrabold text-slate-800 mb-6 border-t pt-6 mt-8">Ganti Kata Sandi</h3>
                    <form action="{{ route('password.custom.update') }}" method="POST" class="space-y-4">
                        @csrf
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Password Lama</label><input type="password" name="current_password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">@error('current_password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror</div>
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Password Baru</label><input type="password" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Min. 8 Karakter">@error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror</div>
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Konfirmasi Password Baru</label><input type="password" name="password_confirmation" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none"></div>
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition mt-4 shadow-md">Simpan Password Baru</button>
                    </form>
                </div>
            </div>

            <!-- SECTION APPOINTMENT -->
            <div id="section-appointment">
                <div class="grid grid-cols-1 mb-8">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                        <h3 class="text-lg font-bold text-slate-800 mb-4 text-center md:text-left">Statistik Pembaca Portal (Views)</h3>
                        <div style="width: 100%; max-width: 600px; height: 200px; margin: 0 auto; position: relative;">
                            <canvas id="viewsChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <table class="min-w-full text-left whitespace-nowrap">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Tanggal & Pemohon</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Tujuan</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Mode</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Status</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($appointments ?? [] as $appt)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 mb-1">
                                            @if(($appt->tipe_pemohon ?? '') == 'individu')
                                                <span class="bg-purple-100 text-purple-700 border border-purple-200 px-2 py-0.5 rounded text-[10px] font-extrabold uppercase">👤 Individu</span>
                                            @else
                                                <span class="bg-blue-100 text-blue-700 border border-blue-200 px-2 py-0.5 rounded text-[10px] font-extrabold uppercase">🏢 Institusi</span>
                                            @endif
                                            <span class="text-[10px] font-bold text-slate-400">Diajukan: {{ $appt->created_at->format('d M Y') }}</span>
                                        </div>
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
                                        <div id="rahasia-instansi-{{ $appt->id }}" class="hidden">{{ $appt->instansi }}</div>
                                        <div id="rahasia-alamat-{{ $appt->id }}" class="hidden">{{ $appt->alamat }}</div>
                                        <div id="rahasia-detail-{{ $appt->id }}" class="hidden">{{ $appt->detail_tujuan }}</div>
                                        <div id="rahasia-waktu-{{ $appt->id }}" class="hidden">{{ $appt->preferensi_waktu ? \Carbon\Carbon::parse($appt->preferensi_waktu)->format('d M Y, H:i') : 'Tidak ada preferensi' }}</div>
                                        <div id="rahasia-tipe-{{ $appt->id }}" class="hidden">{{ strtoupper($appt->tipe_pemohon ?? 'INSTITUSI') }}</div>
                                        <div id="rahasia-status-{{ $appt->id }}" class="hidden">{{ $appt->status }}</div>
                                        <div id="rahasia-catatan-{{ $appt->id }}" class="hidden">{{ $appt->keterangan_tambahan ?? $appt->alasan_penolakan ?? '-' }}</div>
                                        <div id="rahasia-linkmeet-{{ $appt->id }}" class="hidden">{{ $appt->link_meeting ?? '-' }}</div>
                                        <div id="rahasia-gedung-{{ $appt->id }}" class="hidden">{{ $appt->alamat_pertemuan ?? '-' }}</div>

                                        @if($appt->status == 'submitted')
                                            <div class="flex justify-end gap-2">
                                                <button onclick="openDetailModal('{{ $appt->id }}')" class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-1.5 rounded-lg text-sm font-bold transition">Detail</button>
                                                <button onclick="openApproveModal('{{ $appt->id }}', '{{ $appt->mode }}')" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-600 px-3 py-1.5 rounded-lg text-sm font-bold transition">Setujui</button>
                                                <button onclick="openRejectModal('{{ $appt->id }}')" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg text-sm font-bold transition">Tolak</button>
                                            </div>
                                        @else 
                                            <div class="flex items-center justify-end gap-2">
                                                <span class="text-xs font-bold text-slate-400 bg-slate-100 px-2.5 py-1.5 rounded-lg">Telah Diproses</span>
                                                <button onclick="openDetailModal('{{ $appt->id }}')" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1 shadow-sm border border-indigo-200">
                                                    <span>🔍</span> Lihat Detail
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty <tr><td colspan="5" class="px-6 py-10 text-center text-slate-500 italic">Tidak ada antrean saat ini.</td></tr> @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SECTION REKAP JADWAL -->
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
                                    <td class="px-6 py-5 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <span class="inline-block px-3 py-1.5 rounded-lg text-[10px] font-extrabold tracking-wider border {{ $warna }}">{{ $teks }}</span>
                                            @if($jadwal->file_berita_acara)
                                                <a href="{{ asset('storage/' . $jadwal->file_berita_acara) }}" target="_blank" class="bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold text-[10px] px-3 py-1.5 rounded-xl shadow-sm transition flex items-center gap-1">
                                                    <span>✅</span> Lihat Berita Acara
                                                </a>
                                            @else
                                                <button onclick="openBeritaAcaraModal('{{ $jadwal->id }}', '{{ addslashes($jadwal->instansi) }}', '{{ addslashes($jadwal->nama) }}')" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-[10px] px-3 py-1.5 rounded-xl shadow-sm transition flex items-center gap-1">
                                                    <span>📄</span> Terbitkan Berita Acara
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty <tr><td colspan="4" class="px-6 py-12 text-center text-slate-400 italic">Belum ada jadwal yang disetujui.</td></tr> @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SECTION KEBIJAKAN -->
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

                <!-- Riwayat Kebijakan (Dilengkapi Fitur Perbaiki Dokumen / Revisi & Filter Status) -->
                <div class="space-y-4 h-[750px] flex flex-col">
                    <!-- Filter Status -->
                    <div class="flex items-center justify-between mb-4 gap-2 flex-wrap">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            Riwayat Pengajuan & Status 
                            <span class="bg-indigo-100 text-indigo-600 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $allKebijakan->count() }}</span>
                        </h3>
                        <select id="filterStatusKebijakan" onchange="filterRiwayatKebijakan()" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-600 outline-none focus:ring-2 focus:ring-indigo-500 transition cursor-pointer">
                            <option value="all">Semua Status</option>
                            <option value="pending_hukum">Dalam Review Tim Hukum</option>
                            <option value="revisi_hukum">Revisi oleh Tim Hukum</option>
                            <option value="pending_superadmin">Dalam Review Super Admin</option>
                            <option value="revisi_superadmin">Revisi Super Admin</option>
                            <option value="approved">Disetujui / Aktif</option>
                            <option value="rejected">Ditolak / Tidak Aktif</option>
                        </select>
                    </div>

                    <!-- Container Riwayat Kebijakan -->
                    <div class="flex-1 overflow-y-auto space-y-4 pr-2 custom-scrollbar" id="containerRiwayatKebijakan">
                        @forelse($allKebijakan ?? [] as $item)
                            <div class="card-riwayat-kebijakan bg-white rounded-2xl shadow-sm border border-slate-200 p-5 relative overflow-hidden transition hover:border-indigo-300" data-status="{{ $item->status }}">
                                
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <span class="bg-slate-100 text-slate-700 px-2 py-1 rounded text-[10px] font-extrabold uppercase tracking-widest border border-slate-200">{{ $item->tipe_dokumen }}</span>
                                        <span class="text-[11px] text-slate-400 font-bold ml-2">{{ $item->created_at->format('d M Y') }} &bull; Oleh: {{ $item->admin->name ?? 'Anda' }}</span>
                                    </div>

                                    <!-- BADGE STATUS LENGKAP -->
                                    @if($item->status == 'pending_hukum') 
                                        <span class="bg-amber-100 text-amber-700 px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase">Dalam Review Tim Hukum</span>
                                    @elseif($item->status == 'revisi_hukum') 
                                        <span class="bg-blue-100 text-blue-700 px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase">Revisi Tim Hukum</span>
                                    @elseif($item->status == 'pending_superadmin') 
                                        <span class="bg-indigo-100 text-indigo-700 px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase">Dalam Review Pimpinan</span>
                                    @elseif($item->status == 'revisi_superadmin') 
                                        <span class="bg-purple-100 text-purple-700 px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase">Revisi Super Admin</span>
                                    @elseif($item->status == 'approved' || $item->status == 'aktif') 
                                        <span class="bg-emerald-100 text-emerald-700 px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase">Disetujui</span>
                                    @elseif($item->status == 'rejected' || $item->status == 'tidak aktif') 
                                        <span class="bg-red-100 text-red-700 px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase">Ditolak</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase">Menunggu</span>
                                    @endif
                                </div>

                                <h4 class="font-bold text-slate-800 text-base leading-tight">{{ $item->judul }}</h4>
                                @if(isset($item->nomor_kebijakan)) 
                                    <p class="text-xs text-slate-500 mt-1 font-mono">No: {{ $item->nomor_kebijakan }}</p> 
                                @endif

<!-- INFORMASI NAMA AKTOR PENINJAU (TRANSPARANSI AUDIT) -->
<div class="mt-2 text-[11px] text-slate-500 bg-slate-50 p-2.5 rounded-xl border border-slate-100 space-y-0.5">
    <p>👤 <strong>Pembuat:</strong> {{ $item->admin->name ?? 'Anda' }}</p>
    @if($item->timHukum)
        <p>⚖️ <strong>Tim Hukum:</strong> {{ $item->timHukum->name }}</p>
    @endif
    @if($item->superAdmin)
        <p>👑 <strong>Super Admin:</strong> {{ $item->superAdmin->name }}</p>
    @endif
</div>

<!-- Tampilkan Badge Jumlah Revisi Jika Pernah Direvisi -->
@if(($item->revisi_ke ?? 0) > 0)
    <div class="mt-2 bg-purple-50 border border-purple-200 p-2.5 rounded-xl text-xs text-purple-900">
        <div class="font-extrabold flex items-center gap-1.5 mb-1">
            <span>🔄</span> Riwayat Perbaikan (Total: {{ $item->revisi_ke }}x Revisi):
        </div>
        <p class="font-mono text-[11px] font-semibold text-purple-700">
            {{ $item->riwayat_revisi }}
        </p>
    </div>
@endif

<!-- CATATAN / ALASAN PENOLAKAN/REVISI -->
@if(($item->status == 'approved' || $item->status == 'aktif') && $item->keterangan_tambahan)
    <div class="mt-3 bg-emerald-50 border border-emerald-100 p-2.5 rounded-xl text-xs text-emerald-800">
        <strong class="block text-[10px] uppercase text-emerald-600">Catatan Persetujuan:</strong>
        {{ $item->keterangan_tambahan }}
    </div>
@elseif($item->alasan_penolakan)
    <div class="mt-3 bg-red-50 border border-red-100 p-2.5 rounded-xl text-xs text-red-800">
        <strong class="block text-[10px] uppercase text-red-600">Catatan Perbaikan:</strong>
        {{ $item->alasan_penolakan }}
    </div>
@endif

                                <!-- PENYIMPAN DATA UNTUK MODAL DETAIL & REVISI -->
                                <div id="keb-data-{{ $item->id }}" class="hidden" 
                                    data-kategori="{{ $item->kategori_param }}"
                                    data-tipe="{{ $item->tipe_dokumen }}"
                                    data-jenis="{{ $item->jenis ?? $item->jenis_kebijakan ?? '-' }}"
                                    data-perihal="{{ htmlspecialchars($item->perihal ?? '-', ENT_QUOTES) }}"
                                    data-satker="{{ $item->satker_kemlu ?? '-' }}"
                                    data-external="{{ $item->instansi_external ?? '-' }}"
                                    data-tgl-sah="{{ $item->tanggal_disahkan ? \Carbon\Carbon::parse($item->tanggal_disahkan)->format('Y-m-d') : '-' }}"
                                    data-tgl-akhir="{{ $item->tanggal_berakhir ? \Carbon\Carbon::parse($item->tanggal_berakhir)->format('Y-m-d') : '-' }}"
                                    data-ket="{{ htmlspecialchars($item->keterangan ?? '-', ENT_QUOTES) }}"
                                    data-nomor="{{ $item->nomor_kebijakan ?? '-' }}"
                                    data-tahun="{{ $item->tahun ?? '-' }}"
                                    data-instansi="{{ htmlspecialchars($item->instansi ?? '-', ENT_QUOTES) }}"
                                    data-tautan="{{ $item->tautan ?? '' }}"
                                    data-status-text="{{ strtoupper(str_replace('_', ' ', $item->status)) }}"
                                    data-pembuat="{{ $item->admin->name ?? 'Anda' }}"
                                    data-hukum="{{ $item->timHukum->name ?? 'Belum ditinjau' }}"
                                    data-superadmin="{{ $item->superAdmin->name ?? 'Belum ditinjau' }}"
                                    data-catatan="{{ htmlspecialchars($item->alasan_penolakan ?? $item->keterangan_tambahan ?? '-', ENT_QUOTES) }}">
                                </div>

                                <!-- DERETAN TOMBOL AKSI -->
                                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-2 justify-end flex-wrap">
                                    <!-- Tombol Lihat Detail (Selalu Muncul) -->
                                    <button onclick="openDetailKebijakan('{{ $item->id }}')" class="bg-slate-100 text-slate-700 px-3.5 py-2 rounded-xl text-xs font-bold hover:bg-slate-200 transition flex items-center gap-1">
                                        <span>🔍</span> Lihat Detail
                                    </button>

                                    <!-- Tombol Revisi (HANYA MUNCUL JIKA STATUS REVISI) -->
                                    @if(in_array($item->status, ['revisi', 'revisi_hukum', 'revisi_superadmin']))
                                        <button onclick="openRevisiKebijakan('{{ $item->id }}')" class="bg-amber-500 text-slate-950 px-4 py-2 rounded-xl text-xs font-extrabold hover:bg-amber-600 transition shadow-sm flex items-center gap-1">
                                            <span>📝</span> Perbaiki & Ajukan Ulang
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @empty 
                            <div class="text-center text-slate-400 italic py-8 bg-white rounded-2xl border border-slate-100">Belum ada riwayat pengajuan.</div> 
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- SECTION BERITA -->
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
                                    <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">Tempel Berita Luar</label>
                                    <button type="button" onclick="actionTranslate()" id="btnTrans" class="bg-blue-50 text-blue-600 px-3 py-1 rounded-lg text-[10px] font-bold hover:bg-blue-600 hover:text-white transition flex items-center gap-1">
                                        ✨ Terjemahkan ke ID (Groq AI)
                                    </button>
                                </div>
                                <textarea name="body" id="inputBodyBerita" required rows="6" placeholder="Tuliskan isi berita atau paste rilis pers berbahasa asing di sini..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-y"></textarea>
                            </div>

                            <div>
                                <div class="flex justify-between items-end mb-2 mt-4">
                                    <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">Isi Berita</label>
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

                <!-- Riwayat Berita (Dilengkapi Fitur Perbaiki Berita / Revisi) -->
                <div class="xl:col-span-5 space-y-4 h-[900px] flex flex-col">
                    <h3 class="text-xl font-extrabold text-slate-800 flex items-center gap-2">
                        <div class="bg-orange-100 text-orange-600 p-2 rounded-xl"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        Status Draf Berita Anda
                    </h3>
                    
                    <div class="flex-1 overflow-y-auto space-y-4 pr-2 custom-scrollbar">
                        @forelse($riwayatBerita ?? [] as $berita)
                            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 relative overflow-hidden transition hover:border-blue-300 group">
                                <div class="flex justify-between items-start mb-3">
                                    <div><span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-widest">{{ $berita->kategori }}</span></div>
                                    @if($berita->status == 'revisi') <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest">Revisi</span>
                                    @elseif($berita->status == 'pending') <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest animate-pulse">Ditinjau</span>
                                    @elseif($berita->status == 'approved') <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest">Dipublikasi</span>
                                    @else <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest">Ditolak</span> @endif
                                </div>
                                
                                <h4 class="font-bold text-slate-800 text-base leading-snug mb-2">{{ $berita->judul }}</h4>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ \Carbon\Carbon::parse($berita->tanggal)->format('d M Y') }} • {{ $berita->lokasi }}</p>
                                
                                @if(($berita->status == 'revisi' || $berita->status == 'rejected') && $berita->alasan_penolakan)
                                    <div class="mt-4 bg-red-50/50 border border-red-100 rounded-xl p-3 flex gap-3 items-start">
                                        <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <div><span class="block text-[10px] font-extrabold text-red-600 uppercase tracking-widest mb-1">Catatan Penolakan/Revisi:</span><p class="text-xs text-red-800 italic leading-relaxed">{{ $berita->alasan_penolakan }}</p></div>
                                    </div>
                                @endif

                                <!-- TOMBOL REVISI DINAMIS -->
                                @if($berita->status == 'revisi' || $berita->status == 'rejected')
                                    <div class="mt-4 pt-4 border-t border-slate-100">
                                        <div id="berita-data-{{ $berita->id }}" class="hidden"
                                            data-kategori="{{ $berita->kategori }}" data-judul="{{ htmlspecialchars($berita->judul, ENT_QUOTES) }}"
                                            data-tanggal="{{ \Carbon\Carbon::parse($berita->tanggal)->format('Y-m-d') }}" data-lokasi="{{ htmlspecialchars($berita->lokasi, ENT_QUOTES) }}"
                                            data-lead="{{ htmlspecialchars($berita->lead, ENT_QUOTES) }}" data-body="{{ htmlspecialchars($berita->body, ENT_QUOTES) }}" data-closing="{{ htmlspecialchars($berita->closing, ENT_QUOTES) }}">
                                        </div>
                                        <button onclick="openRevisiBerita('{{ $berita->id }}')" class="bg-amber-100 text-amber-700 px-4 py-2 rounded-xl text-xs font-bold hover:bg-amber-600 hover:text-white transition w-full text-center shadow-sm">📝 Revisi Berita Secara Penuh</button>
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
                                <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                <span class="font-bold text-sm">Belum ada berita yang ditulis.</span>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- MODAL REVISI KEBIJAKAN -->
    <div id="revisiKebijakanModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="p-6 border-b border-slate-100 bg-slate-50 flex justify-between items-center shrink-0">
                <h3 class="text-xl font-extrabold text-slate-800">Revisi Dokumen Kebijakan</h3>
                <button type="button" onclick="closeRevisiModals()" class="text-slate-400 hover:text-red-500 transition font-bold text-xl">&times;</button>
            </div>
            <div class="p-6 overflow-y-auto custom-scrollbar flex-1 bg-white">
                <form id="formRevisiKebijakan" method="POST" action="">
                    @csrf @method('PATCH')
                    
                    <div id="rev-fields-mou" class="hidden space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jenis</label><select name="jenis" id="rev-mou-jenis" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"><option value="MoU">MoU</option><option value="PKS">PKS</option></select></div>
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Perihal</label><input type="text" name="perihal" id="rev-mou-perihal" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Satker Kemlu</label><input type="text" name="satker_kemlu" id="rev-mou-satker" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Instansi External</label><input type="text" name="instansi_external" id="rev-mou-external" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tgl Disahkan</label><input type="date" name="tanggal_disahkan" id="rev-mou-tglsah" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tgl Berakhir</label><input type="date" name="tanggal_berakhir" id="rev-mou-tglakhir" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                        </div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Keterangan</label><textarea name="keterangan" id="rev-mou-ket" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></textarea></div>
                    </div>

                    <div id="rev-fields-tik" class="hidden space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jenis Kebijakan</label><input type="text" name="jenis_kebijakan" id="rev-tik-jenis" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nomor Kebijakan</label><input type="text" name="nomor_kebijakan" id="rev-tik-nomor" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                        </div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tahun Penerbitan</label><input type="number" name="tahun" id="rev-tik-tahun" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Perihal</label><input type="text" name="perihal" id="rev-tik-perihal" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tautan</label><input type="url" name="tautan" id="rev-tik-tautan" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                    </div>

                    <div id="rev-fields-non" class="hidden space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jenis Kebijakan</label><input type="text" name="jenis_kebijakan" id="rev-non-jenis" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nomor Kebijakan</label><input type="text" name="nomor_kebijakan" id="rev-non-nomor" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                        </div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Instansi</label><input type="text" name="instansi" id="rev-non-instansi" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tahun Penerbitan</label><input type="number" name="tahun" id="rev-non-tahun" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Perihal</label><input type="text" name="perihal" id="rev-non-perihal" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tautan</label><input type="url" name="tautan" id="rev-non-tautan" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                    </div>

                    <div class="mt-8 pt-4 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" onclick="closeRevisiModals()" class="px-6 py-2.5 bg-slate-100 rounded-xl font-bold text-slate-500">Batal</button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg transition">Simpan & Ajukan Ulang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL REVISI BERITA -->
    <div id="revisiBeritaModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-4xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="p-6 border-b border-slate-100 bg-slate-50 flex justify-between items-center shrink-0">
                <h3 class="text-xl font-extrabold text-slate-800">Revisi Keseluruhan Berita</h3>
                <button type="button" onclick="closeRevisiModals()" class="text-slate-400 hover:text-red-500 transition font-bold text-xl">&times;</button>
            </div>
            <div class="p-6 overflow-y-auto custom-scrollbar flex-1 bg-white">
                <form id="formRevisiBerita" method="POST" action="" enctype="multipart/form-data" class="space-y-4">
                    @csrf @method('PATCH')
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kategori</label><select name="kategori" id="rev-berita-kategori" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"><option value="Dalam Negeri">Dalam Negeri</option><option value="Mancanegara">Mancanegara</option><option value="Kerjasama">Kerjasama</option></select></div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Foto Baru (Abaikan jika tak diubah)</label><input type="file" name="foto" accept="image/*" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700"></div>
                    </div>
                    <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Judul</label><input type="text" name="judul" id="rev-berita-judul" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal</label><input type="date" name="tanggal" id="rev-berita-tanggal" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Lokasi</label><input type="text" name="lokasi" id="rev-berita-lokasi" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                    </div>
                    <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Lead</label><textarea name="lead" id="rev-berita-lead" rows="2" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></textarea></div>
                    <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Isi Berita (Body)</label><textarea name="body" id="rev-berita-body" rows="6" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></textarea></div>
                    <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Closing</label><textarea name="closing" id="rev-berita-closing" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></textarea></div>

                    <div class="mt-8 pt-4 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" onclick="closeRevisiModals()" class="px-6 py-2.5 bg-slate-100 rounded-xl font-bold text-slate-500">Batal</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg transition">Simpan & Ajukan Ulang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL KEBIJAKAN -->
    <div id="detailKebijakanModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="bg-gradient-to-r from-slate-800 to-indigo-900 p-6 flex justify-between items-center shrink-0 text-white">
                <div class="flex items-center gap-3">
                    <div class="bg-white/10 p-2.5 rounded-xl text-xl">📄</div>
                    <div>
                        <h3 class="text-lg font-extrabold" id="dtl-keb-tipe">Detail Dokumen Kebijakan</h3>
                        <p class="text-indigo-200 text-xs" id="dtl-keb-status"></p>
                    </div>
                </div>
                <button type="button" onclick="closeModals()" class="text-slate-400 hover:text-white font-bold text-xl">&times;</button>
            </div>
            
            <div class="p-6 overflow-y-auto space-y-4 bg-slate-50/50 custom-scrollbar flex-1 text-sm">
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Perihal / Judul Dokumen</span>
                    <p class="font-extrabold text-slate-800 text-base" id="dtl-keb-perihal"></p>
                </div>

                <!-- Detail Khusus MoU/PKS -->
                <div id="dtl-box-mou" class="hidden grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/60"><span class="block text-[10px] font-bold text-slate-400 uppercase">Jenis</span><strong class="text-slate-700" id="dtl-mou-jenis"></strong></div>
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/60"><span class="block text-[10px] font-bold text-slate-400 uppercase">Satker Kemlu</span><strong class="text-slate-700" id="dtl-mou-satker"></strong></div>
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/60"><span class="block text-[10px] font-bold text-slate-400 uppercase">Mitra External</span><strong class="text-slate-700" id="dtl-mou-external"></strong></div>
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/60"><span class="block text-[10px] font-bold text-slate-400 uppercase">Masa Berlaku</span><strong class="text-slate-700"><span id="dtl-mou-tglsah"></span> s.d. <span id="dtl-mou-tglakhir"></span></strong></div>
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/60 sm:col-span-2"><span class="block text-[10px] font-bold text-slate-400 uppercase">Keterangan</span><p class="text-slate-600 mt-1" id="dtl-mou-ket"></p></div>
                </div>

                <!-- Detail Khusus TIK -->
                <div id="dtl-box-tik" class="hidden grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/60"><span class="block text-[10px] font-bold text-slate-400 uppercase">Jenis Kebijakan</span><strong class="text-slate-700" id="dtl-tik-jenis"></strong></div>
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/60"><span class="block text-[10px] font-bold text-slate-400 uppercase">Nomor & Tahun</span><strong class="text-slate-700"><span id="dtl-tik-nomor"></span> (Thn: <span id="dtl-tik-tahun"></span>)</strong></div>
                    <div id="dtl-box-instansi" class="hidden bg-white p-3.5 rounded-xl border border-slate-200/60 sm:col-span-2"><span class="block text-[10px] font-bold text-slate-400 uppercase">Instansi Penerbit</span><strong class="text-slate-700" id="dtl-tik-instansi"></strong></div>
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/60 sm:col-span-2 flex items-center justify-between">
                        <div><span class="block text-[10px] font-bold text-slate-400 uppercase">Tautan Dokumen</span><span class="text-xs text-slate-500 truncate max-w-[250px] inline-block" id="dtl-tik-tautan-text"></span></div>
                        <a href="" id="dtl-tik-tautan-btn" target="_blank" class="bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">Buka Link →</a>
                    </div>
                </div>

                <!-- Riwayat Audit Aktor -->
                <div class="bg-indigo-50/50 p-4 rounded-2xl border border-indigo-100 space-y-2">
                    <span class="block text-[10px] font-extrabold text-indigo-900 uppercase tracking-widest border-b border-indigo-100 pb-1">Jalur Verifikasi & Aktor</span>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-xs">
                        <div><span class="text-slate-400 block text-[10px]">Pembuat:</span><strong class="text-slate-700" id="dtl-act-pembuat"></strong></div>
                        <div><span class="text-slate-400 block text-[10px]">Verifikator Hukum:</span><strong class="text-indigo-700" id="dtl-act-hukum"></strong></div>
                        <div><span class="text-slate-400 block text-[10px]">Super Admin:</span><strong class="text-indigo-700" id="dtl-act-superadmin"></strong></div>
                    </div>
                </div>

                <!-- Catatan Pimpinan/Hukum -->
                <div class="bg-amber-50/70 p-4 rounded-2xl border border-amber-200/80">
                    <span class="block text-[10px] font-extrabold text-amber-900 uppercase tracking-widest mb-1">Catatan Verifikasi / Revisi</span>
                    <p class="text-xs text-amber-950 font-medium italic leading-relaxed" id="dtl-act-catatan"></p>
                </div>
            </div>

            <div class="p-5 border-t bg-white flex justify-end">
                <button type="button" onclick="closeModals()" class="bg-slate-800 hover:bg-slate-900 text-white px-6 py-2.5 rounded-xl text-xs font-bold transition">Tutup Jendela</button>
            </div>
        </div>
    </div>

    <!-- MODALS ADMIN (Appointment, Radar) -->
    <div id="detailModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 flex justify-between items-center shrink-0">
                <div class="flex items-center gap-4 text-white">
                    <div class="bg-white/20 p-3 rounded-2xl">📋</div>
                    <div>
                        <h3 class="text-xl font-extrabold">Detail Pengajuan</h3>
                        <p class="text-blue-100 text-sm" id="mdl-tipe">Informasi User</p>
                    </div>
                </div>
                <button type="button" onclick="closeModals()" class="text-white/70 hover:text-white bg-white/10 p-2 rounded-full transition">X</button>
            </div>
            <div class="p-6 overflow-y-auto space-y-6 bg-slate-50/50">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 flex gap-4"><div class="bg-blue-50 p-2.5 rounded-xl text-blue-600 shrink-0">📍</div><div><span class="block text-[10px] font-extrabold text-slate-400 uppercase">Instansi / Komunitas</span><span id="mdl-instansi" class="block text-sm font-bold text-slate-800"></span></div></div>
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 flex gap-4"><div class="bg-orange-50 p-2.5 rounded-xl text-orange-600 shrink-0">⏰</div><div><span class="block text-[10px] font-extrabold text-slate-400 uppercase">Waktu Usulan</span><span id="mdl-waktu" class="block text-sm font-bold text-slate-800"></span></div></div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-100"><span class="block text-[10px] font-extrabold text-slate-400 uppercase mb-2">Alamat Pemohon</span><span id="mdl-alamat" class="block text-sm font-semibold text-slate-700 italic"></span></div>
                <div><span class="block text-[10px] font-extrabold text-slate-400 uppercase mb-2 pl-1">Detail Tujuan Pembahasan</span><div id="mdl-detail" class="bg-indigo-50/50 p-6 rounded-2xl border border-indigo-100/50 text-sm text-slate-700 min-h-[100px] whitespace-pre-wrap font-medium"></div></div>
                
                <!-- BOX HASIL KEPUTUSAN ADMIN (HANYA MUNCUL JIKA SUDAH DIPROSES) -->
                <div id="mdl-box-hasil" class="hidden bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="text-xs font-extrabold text-slate-500 uppercase tracking-widest">Status Keputusan Admin:</span>
                        <span id="mdl-status-text" class="text-xs font-black uppercase"></span>
                    </div>
                    <div><span class="block text-[10px] font-bold text-slate-400 uppercase">Catatan / Alasan Pimpinan</span><p id="mdl-catatan" class="text-sm font-semibold text-slate-800 mt-1"></p></div>
                    <div class="pt-2 border-t"><span class="block text-[10px] font-bold text-slate-400 uppercase">Lokasi / Tautan Resmi</span><p id="mdl-lokasi" class="text-sm font-bold text-indigo-600 mt-1"></p></div>
                </div>
            </div>
            <div class="p-6 border-t bg-white flex justify-end"><button type="button" onclick="closeModals()" class="bg-slate-800 text-white px-8 py-3 rounded-xl text-sm font-bold">Tutup Jendela</button></div>
        </div>
    </div>

    <!-- MODAL APPROVE -->
    <div id="approveModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-6 border border-slate-100">
            <h3 class="text-xl font-bold text-slate-800 mb-4">Setujui Pertemuan</h3>
            <form id="approveForm" method="POST" action="" class="space-y-4">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="approved">
                <div><label class="block text-sm font-bold text-slate-700 mb-1">Jadwal Fix</label><input type="datetime-local" name="tanggal_waktu_pertemuan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                <div id="daringFields" class="hidden space-y-4 border-t pt-4"><div><label class="block text-sm font-bold text-slate-700 mb-1">Link Meet</label><input type="url" name="link_meeting" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div></div>
                <div id="luringFields" class="hidden space-y-4 border-t pt-4"><div><label class="block text-sm font-bold text-slate-700 mb-1">Gedung</label><input type="text" name="alamat_pertemuan" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div><div><label class="block text-sm font-bold text-slate-700 mb-1">Link Maps</label><input type="url" name="link_maps" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div></div>
                <div class="border-t pt-4"><label class="block text-sm font-bold text-slate-700 mb-1">Catatan</label><textarea name="keterangan_tambahan" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></textarea></div>
                <div class="pt-4 flex justify-end gap-3"><button type="button" onclick="closeModals()" class="px-4 py-2 font-bold text-slate-500">Batal</button><button type="submit" class="bg-emerald-500 text-white px-6 py-2 rounded-xl font-bold">Kirim</button></div>
            </form>
        </div>
    </div>

    <!-- MODAL REJECT -->
    <div id="rejectModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-6 border border-red-50">
            <h3 class="text-xl font-bold text-red-600 mb-4">Tolak Permohonan</h3>
            <form id="rejectForm" method="POST" action="" class="space-y-4">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="rejected">
                <div><label class="block text-sm font-bold text-slate-700 mb-1">Alasan Penolakan</label><textarea name="alasan_penolakan" required rows="4" class="w-full bg-red-50/50 border border-red-200 rounded-xl p-3 text-sm resize-none"></textarea></div>
                <div class="pt-4 flex justify-end gap-3"><button type="button" onclick="closeModals()" class="px-4 py-2 font-bold text-slate-500">Batal</button><button type="submit" class="bg-red-500 text-white px-6 py-2 rounded-xl font-bold">Kirim Penolakan</button></div>
            </form>
        </div>
    </div>

    <!-- MODAL TERBITKAN BERITA ACARA PERTEMUAN -->
    <div id="beritaAcaraModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 flex justify-between items-center shrink-0 text-white">
                <div class="flex items-center gap-3">
                    <div class="bg-white/10 p-2.5 rounded-xl text-xl">📄</div>
                    <div>
                        <h3 class="text-lg font-extrabold">Terbitkan Berita Acara Pertemuan</h3>
                        <p class="text-blue-100 text-xs" id="bam-title">Mitra: -</p>
                    </div>
                </div>
                <button type="button" onclick="closeModals()" class="text-white/70 hover:text-white font-bold text-xl">&times;</button>
            </div>
            
            <form id="formBeritaAcaraPertemuan" method="POST" action="" class="p-6 space-y-4 bg-white flex-1 overflow-y-auto">
                @csrf
                
                <div class="bg-blue-50 border border-blue-200 p-3.5 rounded-2xl text-xs text-blue-900 leading-relaxed">
                    💡 <strong>Catatan Admin:</strong> Tuliskan poin-poin kesimpulan rapat atau kesepakatan akhir pertemuan. Sistem akan mencetaknya ke dalam format dokumen PDF resmi bertanda tangan digital.
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Pokok Pembahasan & Kesimpulan Rapat <span class="text-red-500">*</span>
                    </label>
                    <textarea name="catatan_pertemuan" rows="6" required placeholder="Contoh:&#10;1. Pihak Kemlu menyetujui usulan penjadwalan audiensi lanjutan.&#10;2. Mitra eksternal akan mengirimkan draf teknis paling lambat hari Jumat.&#10;3. Rapat ditutup dengan kesepakatan kolaborasi portal sistem..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none leading-relaxed"></textarea>
                </div>

                <!-- OPSI KIRIM EMAIL OTOMATIS -->
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex items-center justify-between">
                    <div>
                        <label class="font-extrabold text-xs text-slate-800 block cursor-pointer" for="cb-kirim-email">📧 Kirim PDF ke Email Tamu Eksternal</label>
                        <span class="text-[11px] text-slate-500">Otomatis mengirimkan salinan PDF ke alamat email perwakilan mitra.</span>
                    </div>
                    <input type="checkbox" name="kirim_email" id="cb-kirim-email" value="1" checked class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 cursor-pointer">
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" onclick="closeModals()" class="px-6 py-2.5 bg-slate-100 rounded-xl font-bold text-slate-500 text-xs hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-extrabold text-xs shadow-lg transition flex items-center gap-1.5">
                        <span>📄</span> Terbitkan & Simpan PDF
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL RADAR GLOBAL -->
    <div id="radarModal" class="fixed inset-0 bg-slate-900/60 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-4xl p-8 flex flex-col max-h-[90vh]">
            <div class="flex justify-between items-center mb-4"><h3 class="text-xl font-black text-slate-800">🌍 Radar Berita Internasional</h3><button onclick="closeRadar()" class="text-slate-400 hover:text-red-500">X</button></div>
            <div class="mb-6 flex gap-3"><input type="text" id="inputCariRadar" placeholder="Ketik topik..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500 outline-none" onkeypress="if(event.key === 'Enter') openRadar()"><button type="button" onclick="openRadar()" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg">Cari Berita</button></div>
            <div id="radarContent" class="overflow-y-auto space-y-4 custom-scrollbar pr-2 flex-1"><p class="text-center italic text-slate-400">Sedang menyapu berita global...</p></div>
        </div>
    </div>

    <!-- SCRIPT INITIALIZATION -->
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        document.addEventListener("DOMContentLoaded", function() {
            const viewsCtx = document.getElementById('viewsChart');
            const viewsData = @json($chartViews ?? ['labels'=>[], 'data'=>[]]);
            if(viewsCtx && viewsData.labels.length > 0) {
                new Chart(viewsCtx.getContext('2d'), {
                    type: 'doughnut', data: { labels: viewsData.labels, datasets: [{ label: 'Total Views', data: viewsData.data, backgroundColor: ['#4F46E5', '#10B981', '#F59E0B', '#EF4444'], borderWidth: 0, hoverOffset: 4 }] },
                    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
                });
            }
        });

        // ======================= FUNGSI LIHAT DETAIL KEBIJAKAN =======================
        function openDetailKebijakan(id) {
            const data = document.getElementById('keb-data-' + id).dataset;
            
            document.getElementById('dtl-keb-tipe').innerText = data.tipe;
            document.getElementById('dtl-keb-status').innerText = 'Status Saat Ini: ' + data.statusText;
            document.getElementById('dtl-keb-perihal').innerText = data.perihal;

            document.getElementById('dtl-box-mou').classList.add('hidden');
            document.getElementById('dtl-box-tik').classList.add('hidden');
            document.getElementById('dtl-box-instansi').classList.add('hidden');

            if (data.kategori === 'mou') {
                document.getElementById('dtl-box-mou').classList.remove('hidden');
                document.getElementById('dtl-mou-jenis').innerText = data.jenis;
                document.getElementById('dtl-mou-satker').innerText = data.satker;
                document.getElementById('dtl-mou-external').innerText = data.external;
                document.getElementById('dtl-mou-tglsah').innerText = data.tglSah !== '-' ? data.tglSah : 'Belum diset';
                document.getElementById('dtl-mou-tglakhir').innerText = data.tglAkhir !== '-' ? data.tglAkhir : 'Belum diset';
                document.getElementById('dtl-mou-ket').innerText = data.ket !== '-' ? data.ket : 'Tidak ada keterangan tambahan.';
            } else {
                document.getElementById('dtl-box-tik').classList.remove('hidden');
                document.getElementById('dtl-tik-jenis').innerText = data.jenis;
                document.getElementById('dtl-tik-nomor').innerText = data.nomor;
                document.getElementById('dtl-tik-tahun').innerText = data.tahun;
                document.getElementById('dtl-tik-tautan-text').innerText = data.tautan || 'Tidak ada tautan';
                
                const btnLink = document.getElementById('dtl-tik-tautan-btn');
                if (data.tautan && data.tautan !== '-') {
                    btnLink.href = data.tautan;
                    btnLink.classList.remove('hidden');
                } else {
                    btnLink.classList.add('hidden');
                }

                if (data.kategori === 'tik_non_kemlu') {
                    document.getElementById('dtl-box-instansi').classList.remove('hidden');
                    document.getElementById('dtl-tik-instansi').innerText = data.instansi;
                }
            }

            document.getElementById('dtl-act-pembuat').innerText = data.pembuat;
            document.getElementById('dtl-act-hukum').innerText = data.hukum;
            document.getElementById('dtl-act-superadmin').innerText = data.superadmin;
            document.getElementById('dtl-act-catatan').innerText = data.catatan !== '-' ? data.catatan : 'Tidak ada catatan khusus.';

            document.getElementById('detailKebijakanModal').classList.replace('hidden', 'flex');
        }

        // ======================= FUNGSI MODAL REVISI =======================
        function openRevisiKebijakan(id) {
            const data = document.getElementById('keb-data-'+id).dataset;
            const form = document.getElementById('formRevisiKebijakan');
            
            ['rev-fields-mou', 'rev-fields-tik', 'rev-fields-non'].forEach(f => {
                document.getElementById(f).classList.add('hidden');
                document.querySelectorAll(`#${f} input, #${f} select, #${f} textarea`).forEach(i => i.disabled = true);
            });

            if (data.kategori === 'mou') {
                document.getElementById('rev-fields-mou').classList.remove('hidden');
                document.querySelectorAll('#rev-fields-mou input, #rev-fields-mou select, #rev-fields-mou textarea').forEach(i => i.disabled = false);
                document.getElementById('rev-mou-jenis').value = data.jenis;
                document.getElementById('rev-mou-perihal').value = data.perihal;
                document.getElementById('rev-mou-satker').value = data.satker;
                document.getElementById('rev-mou-external').value = data.external;
                document.getElementById('rev-mou-tglsah').value = data.tglSah;
                document.getElementById('rev-mou-tglakhir').value = data.tglAkhir;
                document.getElementById('rev-mou-ket').value = data.ket;
            } else if (data.kategori === 'tik_kemlu') {
                document.getElementById('rev-fields-tik').classList.remove('hidden');
                document.querySelectorAll('#rev-fields-tik input, #rev-fields-tik select, #rev-fields-tik textarea').forEach(i => i.disabled = false);
                document.getElementById('rev-tik-jenis').value = data.jenis;
                document.getElementById('rev-tik-nomor').value = data.nomor;
                document.getElementById('rev-tik-tahun').value = data.tahun;
                document.getElementById('rev-tik-perihal').value = data.perihal;
                document.getElementById('rev-tik-tautan').value = data.tautan;
            } else if (data.kategori === 'tik_non_kemlu') {
                document.getElementById('rev-fields-non').classList.remove('hidden');
                document.querySelectorAll('#rev-fields-non input, #rev-fields-non select, #rev-fields-non textarea').forEach(i => i.disabled = false);
                document.getElementById('rev-non-jenis').value = data.jenis;
                document.getElementById('rev-non-nomor').value = data.nomor;
                document.getElementById('rev-non-instansi').value = data.instansi;
                document.getElementById('rev-non-tahun').value = data.tahun;
                document.getElementById('rev-non-perihal').value = data.perihal;
                document.getElementById('rev-non-tautan').value = data.tautan;
            }

            form.action = `/admin/kebijakan/update/${data.kategori}/${id}`;
            document.getElementById('revisiKebijakanModal').classList.replace('hidden', 'flex');
        }

        function openRevisiBerita(id) {
            const data = document.getElementById('berita-data-'+id).dataset;
            const form = document.getElementById('formRevisiBerita');
            
            document.getElementById('rev-berita-kategori').value = data.kategori;
            document.getElementById('rev-berita-judul').value = data.judul;
            document.getElementById('rev-berita-tanggal').value = data.tanggal;
            document.getElementById('rev-berita-lokasi').value = data.lokasi;
            document.getElementById('rev-berita-lead').value = data.lead;
            document.getElementById('rev-berita-body').value = data.body;
            document.getElementById('rev-berita-closing').value = data.closing;
            
            form.action = `/admin/berita/update/${id}`;
            document.getElementById('revisiBeritaModal').classList.replace('hidden', 'flex');
        }

        function closeRevisiModals() {
            document.getElementById('revisiKebijakanModal').classList.replace('flex', 'hidden');
            document.getElementById('revisiBeritaModal').classList.replace('flex', 'hidden');
        }

        // ======================= FUNGSI LAINNYA =======================
        function switchMenuAdmin(menuName) {
            const sections = ['appointment', 'rekap_jadwal', 'kebijakan', 'berita', 'profil'];
            const titles = { 'appointment': ['Antrean Appointment', 'Tinjau dan proses permohonan.'], 'rekap_jadwal': ['Rekap Jadwal Pertemuan', 'Daftar jadwal disetujui.'], 'kebijakan': ['Manajemen Kebijakan', 'Input draf kebijakan TIK/MoU.'], 'berita': ['Kelola Portal Berita', 'Tulis draf berita.'], 'profil': ['Profil & Keamanan', 'Lengkapi identitas diri.'] };
            sections.forEach(section => {
                const el = document.getElementById('section-' + section);
                const btn = document.getElementById('btn-' + section);
                if(!el || !btn) return;
                if (section === menuName) {
                    el.classList.remove('hidden');
                    if(section === 'kebijakan' || section === 'berita') el.classList.add('grid');
                    btn.className = "w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/50 font-bold transition";
                } else {
                    el.classList.add('hidden'); el.classList.remove('grid');
                    btn.className = "w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition text-slate-300 hover:text-white text-sm font-medium";
                }
            });
            document.getElementById('header-title').innerText = titles[menuName][0]; document.getElementById('header-desc').innerText = titles[menuName][1];
        }

        function switchTab(tabId) {
            document.getElementById('tab-mou').classList.add('hidden'); document.getElementById('tab-tik').classList.add('hidden'); document.getElementById('tab-non').classList.add('hidden');
            ['btn-mou', 'btn-tik', 'btn-non'].forEach(id => document.getElementById(id).className = 'flex-1 py-4 text-slate-500 hover:text-slate-800 transition');
            document.getElementById(tabId).classList.remove('hidden'); document.getElementById(tabId.replace('tab', 'btn')).className = 'flex-1 py-4 text-indigo-700 border-b-2 border-indigo-600 bg-white font-bold transition';
        }

        function openDetailModal(id) {
            document.getElementById('mdl-instansi').innerText = document.getElementById('rahasia-instansi-'+id).innerText;
            document.getElementById('mdl-alamat').innerText = document.getElementById('rahasia-alamat-'+id).innerText;
            document.getElementById('mdl-detail').innerText = document.getElementById('rahasia-detail-'+id).innerText;
            document.getElementById('mdl-waktu').innerText = document.getElementById('rahasia-waktu-'+id).innerText;
            
            const tipeEl = document.getElementById('mdl-tipe');
            if(tipeEl) {
                tipeEl.innerText = 'Kategori Pemohon: ' + (document.getElementById('rahasia-tipe-'+id)?.innerText || 'INSTITUSI');
            }
            
            const status = document.getElementById('rahasia-status-'+id)?.innerText || 'submitted';
            const boxHasil = document.getElementById('mdl-box-hasil');
            if (boxHasil) {
                if (status !== 'submitted') {
                    boxHasil.classList.remove('hidden');
                    document.getElementById('mdl-status-text').innerText = status === 'approved' ? 'DISETUJUI' : 'DITOLAK';
                    document.getElementById('mdl-status-text').className = status === 'approved' ? 'text-xs font-black text-emerald-600' : 'text-xs font-black text-red-600';
                    document.getElementById('mdl-catatan').innerText = document.getElementById('rahasia-catatan-'+id)?.innerText || '-';
                    
                    const linkMeet = document.getElementById('rahasia-linkmeet-'+id)?.innerText;
                    const gedung = document.getElementById('rahasia-gedung-'+id)?.innerText;
                    const lokasiEl = document.getElementById('mdl-lokasi');
                    if (linkMeet && linkMeet !== '-') {
                        lokasiEl.innerHTML = `<a href="${linkMeet}" target="_blank" class="text-blue-600 underline">${linkMeet}</a>`;
                    } else {
                        lokasiEl.innerText = gedung && gedung !== '-' ? gedung : 'Tidak ada detail lokasi khusus';
                    }
                } else {
                    boxHasil.classList.add('hidden');
                }
            }

            document.getElementById('detailModal').classList.replace('hidden', 'flex');
        }

        function openApproveModal(id, mode) {
            document.getElementById('approveModal').classList.replace('hidden', 'flex');
            document.getElementById('approveForm').action = `/admin/appointment/${id}/status`;
            if (mode.toLowerCase() === 'daring') { document.getElementById('daringFields').classList.remove('hidden'); document.getElementById('luringFields').classList.add('hidden'); }
            else { document.getElementById('daringFields').classList.add('hidden'); document.getElementById('luringFields').classList.remove('hidden'); }
        }

        function openRejectModal(id) { document.getElementById('rejectModal').classList.replace('hidden', 'flex'); document.getElementById('rejectForm').action = `/admin/appointment/${id}/status`; }
        
        function openBeritaAcaraModal(id, instansi, nama) {
            document.getElementById('bam-title').innerText = 'Mitra: ' + instansi + ' (' + nama + ')';
            document.getElementById('formBeritaAcaraPertemuan').action = '/admin/appointment/' + id + '/berita-acara';
            document.getElementById('beritaAcaraModal').classList.replace('hidden', 'flex');
        }

        function closeModals() { 
            ['approveModal', 'rejectModal', 'detailModal', 'detailKebijakanModal', 'beritaAcaraModal'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.classList.replace('flex', 'hidden');
            }); 
        }

        window.onclick = function(event) { if (event.target.classList.contains('fixed')) { closeModals(); closeRevisiModals(); } }

        async function actionTranslate() {
            const bodyEl = document.getElementById('inputBodyBerita');
            if(!bodyEl.value) return alert('Isi kolom Body terlebih dahulu!');
            const btn = document.getElementById('btnTrans'); btn.innerText = 'AI Menerjemahkan...'; btn.disabled = true;
            try {
                const req = await fetch('/admin/api/berita/translate', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }, body: JSON.stringify({ text: bodyEl.value }) });
                const res = await req.json(); if(res.translated_text) bodyEl.value = res.translated_text; else alert('Gagal: ' + (res.error || 'Terjadi kesalahan pada AI'));
            } catch (e) { alert('Terjadi kesalahan jaringan.'); }
            btn.innerText = '✨ Terjemahkan (AI)'; btn.disabled = false;
        }

        async function actionGenerateLead() {
            const bodyEl = document.getElementById('inputBodyBerita'); const leadEl = document.getElementById('inputLeadBerita');
            if(!bodyEl.value) return alert('AI butuh teks di Body!');
            const btn = document.getElementById('btnLead'); btn.innerText = 'AI Menulis...'; btn.disabled = true;
            try {
                const req = await fetch('/admin/api/berita/generate-lead', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }, body: JSON.stringify({ body: bodyEl.value }) });
                const res = await req.json(); if(res.lead) leadEl.value = res.lead; else alert('Gagal: ' + (res.error || 'Terjadi kesalahan pada AI'));
            } catch (e) { alert('Terjadi kesalahan jaringan.'); }
            btn.innerText = '🤖 Buat Lead (AI)'; btn.disabled = false;
        }

        async function openRadar() {
            document.getElementById('radarModal').classList.replace('hidden', 'flex');
            const container = document.getElementById('radarContent'); const keyword = document.getElementById('inputCariRadar')?.value.trim() || '';
            container.innerHTML = '<p class="text-center italic text-slate-400">🌐 Sedang menyapu berita global...</p>';
            try {
                const url = keyword ? `/admin/api/berita/radar-global?q=${encodeURIComponent(keyword)}` : '/admin/api/berita/radar-global';
                const res = await fetch(url); const data = await res.json();
                if (data.results && data.results.length > 0) {
                    container.innerHTML = data.results.map(n => `<div class="p-5 border border-slate-100 rounded-2xl hover:bg-slate-50 transition shadow-sm bg-white"><span class="text-[10px] font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2 py-1 rounded">${n.source_id || 'Media'}</span><h4 class="font-bold text-slate-800 text-base mt-2 mb-2">${n.title || 'Tanpa Judul'}</h4><p class="text-sm text-slate-500 line-clamp-2">${n.description || '-'}</p><a href="${n.link}" target="_blank" class="text-xs text-indigo-600 font-bold mt-3 inline-block underline">Baca Sumber Asli →</a></div>`).join('');
                } else container.innerHTML = '<p class="text-center text-slate-500">Tidak ada berita yang ditemukan.</p>';
            } catch (error) { container.innerHTML = '<p class="text-center text-red-500 italic">Gagal mengambil data berita global.</p>'; }
        }
        function closeRadar() { document.getElementById('radarModal').classList.replace('flex', 'hidden'); }

        // ======================= FUNGSI FILTER RIWAYAT KEBIJAKAN =======================
        function filterRiwayatKebijakan() {
            const selectedStatus = document.getElementById('filterStatusKebijakan').value;
            const cards = document.querySelectorAll('.card-riwayat-kebijakan');

            cards.forEach(card => {
                const status = card.getAttribute('data-status');
                if (selectedStatus === 'all' || 
                    status === selectedStatus || 
                    (selectedStatus === 'approved' && (status === 'aktif' || status === 'approved')) || 
                    (selectedStatus === 'rejected' && (status === 'tidak aktif' || status === 'rejected'))) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>