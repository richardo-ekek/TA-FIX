<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - Pusat Komando</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-50 font-sans flex min-h-screen">

    <!-- SIDEBAR -->
    <div class="w-64 bg-indigo-950 text-white flex flex-col shadow-2xl z-20">
        <div class="p-6 text-xl font-extrabold border-b border-indigo-900/50 flex items-center gap-2">
            <div class="bg-indigo-600 p-1 rounded-lg w-8 h-8 flex items-center justify-center overflow-hidden">
                @if(auth()->user()->foto_profil)
                    <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                @endif
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
            <button type="button" onclick="switchMenu('profil')" id="btn-profil" class="w-full text-left px-4 py-3 rounded-xl text-indigo-300 hover:bg-indigo-800 hover:text-white transition font-medium">
                Profil & Keamanan
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

    <!-- KONTEN UTAMA -->
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

            <!-- SECTION PROFIL & GANTI PASSWORD -->
            <div id="section-profil" class="hidden">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8 max-w-3xl">
                    <h3 class="text-xl font-extrabold text-slate-800 mb-6">Identitas Akun & Foto</h3>
                    
                    <form action="{{ route('profile.update_foto') }}" method="POST" enctype="multipart/form-data" class="mb-8 flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        @csrf
                        <div class="shrink-0 w-16 h-16 rounded-full overflow-hidden bg-indigo-100 border-2 border-white shadow-sm flex items-center justify-center text-xl font-bold text-indigo-600">
                            @if(auth()->user()->foto_profil)
                                <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" class="w-full h-full object-cover">
                            @else
                                {{ substr(auth()->user()->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Pilih Foto (Max 2MB)</label>
                            <input type="file" name="foto_profil" required accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 transition">
                        </div>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-xl transition shadow-md text-sm">Update Foto</button>
                    </form>

                    <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50 p-6 rounded-2xl border border-slate-100">
                        <div><span class="block text-[10px] font-bold text-slate-400 uppercase">Nama Terdaftar</span><span class="font-extrabold text-slate-800">{{ auth()->user()->name }}</span></div>
                        <div><span class="block text-[10px] font-bold text-slate-400 uppercase">Email Terdaftar</span><span class="font-extrabold text-slate-800">{{ auth()->user()->email }}</span></div>
                        <div class="md:col-span-2"><span class="block text-[10px] font-bold text-slate-400 uppercase">Hak Akses</span><span class="font-extrabold text-indigo-600 uppercase">{{ auth()->user()->role }}</span></div>
                    </div>
                    
                    <h3 class="text-xl font-extrabold text-slate-800 mb-6 border-t pt-6">Lengkapi Profil Pimpinan</h3>
                    <form action="{{ route('profile.custom.update_detail') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"></div>
                            
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nomor Induk Pegawai (NIP)</label>
                            <input type="text" name="nip" value="{{ auth()->user()->nip }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Masukkan NIP..."></div>
                            
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ auth()->user()->tanggal_lahir }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"></div>
                            
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Status Jabatan</label>
                            <input type="text" name="jabatan" value="{{ auth()->user()->jabatan }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Contoh: Kepala Bagian"></div>

                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nomor Telepon</label>
                            <input type="text" name="no_telp" value="{{ auth()->user()->no_telp }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="0812345..."></div>
                            
                            <div class="md:col-span-2"><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Alamat Rumah</label>
                            <textarea name="alamat" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">{{ auth()->user()->alamat }}</textarea></div>
                        </div>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl transition mt-2 shadow-md">Simpan Profil</button>
                    </form>

                    <h3 class="text-xl font-extrabold text-slate-800 mb-6 flex items-center gap-2 border-t pt-6 mt-8">Ganti Kata Sandi</h3>
                    <form action="{{ route('password.custom.update') }}" method="POST" class="space-y-4">
                        @csrf
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Password Lama</label><input type="password" name="current_password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">@error('current_password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror</div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Password Baru</label><input type="password" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Min. 8 Karakter">@error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror</div>
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Konfirmasi Password Baru</label><input type="password" name="password_confirmation" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"></div>
                        </div>
                        <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 px-6 rounded-xl transition mt-4 shadow-md w-full md:w-auto">Simpan Password Baru</button>
                    </form>
                </div>
            </div>

            <!-- SECTION MANAJEMEN -->
            <div id="section-manajemen">
                
                <!-- Grafik Analitik -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Views Chart -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                        <h3 class="text-lg font-bold text-slate-800 mb-4 text-center md:text-left">Statistik Pembaca Portal (Views)</h3>
                        <div style="width: 100%; max-width: 600px; height: 300px; margin: 0 auto; position: relative;">
                            <canvas id="viewsChart"></canvas>
                        </div>
                    </div>

                    <!-- Uploads Chart (Dengan Filter) -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 flex flex-col">
                        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-3">
                            <h3 class="text-lg font-bold text-slate-800">Detail Status Unggahan Admin</h3>
                            <select id="filterUploadsChart" onchange="updateUploadsChart()" class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-xs font-bold text-slate-600 outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer shadow-sm">
                                <option value="all">Semua Kategori</option>
                                <option value="berita">Hanya Berita</option>
                                <option value="kebijakan">Hanya Kebijakan</option>
                            </select>
                        </div>
                        <div style="width: 100%; max-width: 600px; height: 300px; margin: 0 auto; position: relative;" class="flex-1">
                            <canvas id="uploadsChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                    <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
                        <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Daftar Admin & Tim Hukum Aktif
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left whitespace-nowrap">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-xs font-bold text-slate-400 uppercase tracking-wider rounded-l-xl">Info Akun & Hak Akses</th>
                                        <th class="px-4 py-3 text-xs font-bold text-slate-400 uppercase tracking-wider text-right rounded-r-xl">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($admins ?? [] as $adm)
                                        <tr class="hover:bg-slate-50/50 transition">
                                            <td class="px-4 py-4 flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden flex items-center justify-center font-bold text-slate-500">
                                                    @if($adm->foto_profil)
                                                        <img src="{{ asset('storage/' . $adm->foto_profil) }}" class="w-full h-full object-cover">
                                                    @else
                                                        {{ substr($adm->name, 0, 1) }}
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="flex items-center gap-2">
                                                        <p class="font-extrabold text-slate-800 text-sm">{{ $adm->name }}</p>
                                                        @if($adm->role === 'tim_hukum')
                                                            <span class="bg-amber-100 text-amber-800 border border-amber-300 text-[10px] font-extrabold px-2 py-0.5 rounded-md uppercase tracking-wider">
                                                                ⚖️ Tim Hukum
                                                            </span>
                                                        @else
                                                            <span class="bg-blue-100 text-blue-700 border border-blue-200 text-[10px] font-extrabold px-2 py-0.5 rounded-md uppercase tracking-wider">
                                                                🛡️ Admin Operasional
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <p class="text-xs text-slate-500 mt-0.5">{{ $adm->email }}</p>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 text-right">
                                                <form action="{{ route('super_admin.admin.destroy', $adm->id) }}" method="POST" onsubmit="return confirm('Hapus Akun secara permanen?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="bg-red-50 hover:bg-red-500 text-red-600 hover:text-white px-4 py-2 rounded-lg text-xs font-bold transition">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="2" class="px-4 py-8 text-center text-slate-500 font-medium italic">Belum ada akun Admin atau Tim Hukum.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Buat Akun Admin / Tim Hukum</h3>
                        <p class="text-xs text-slate-500 mb-6">Tambahkan akun baru dengan hak akses yang sesuai dengan perannya.</p>
                        <form action="{{ route('super_admin.admin.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Nama Lengkap</label>
                                <input type="text" name="name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Email</label>
                                <input type="email" name="email" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Password</label>
                                <input type="text" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition" placeholder="Min. 8 karakter">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Pilih Hak Akses (Role)</label>
                                <select name="role" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none cursor-pointer">
                                    <option value="admin">Admin Operasional (Input Draf & Berita)</option>
                                    <option value="tim_hukum">Tim Hukum (Verifikasi Legalitas)</option>
                                </select>
                                @error('role') 
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold py-3.5 px-4 rounded-xl transition shadow-md mt-2">Tambahkan Akun</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- SECTION TINJAUAN KEBIJAKAN -->
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
                                        <span class="text-[10px] font-bold text-slate-400">Input: {{ $item->created_at->format('d M Y, H:i') }} &bull; Oleh: {{ $item->admin->name ?? 'Sistem' }}</span>
                                    </div>
<h4 class="font-extrabold text-slate-800 text-base">{{ $item->judul }}</h4>

<!-- Informasi Admin Pengaju dan Verifikator Hukum -->
<p class="text-xs text-slate-500 mt-1">
    Diajukan oleh Admin: <strong class="text-slate-800">{{ $item->admin->name ?? '-' }}</strong> | 
    Verifikator Hukum: <strong class="text-indigo-600">{{ $item->timHukum->name ?? 'Tim Hukum' }}</strong>
</p>

<p class="text-xs text-slate-500 mt-1">
    @if($item->kategori == 'mou') {{ $item->satker_kemlu }} &mdash; {{ $item->instansi_external }}
    @else No: {{ $item->nomor_kebijakan }} | Thn: {{ $item->tahun }} @endif
</p>
                                </div>
                                
                                <!-- ============================================================= -->
                                <!-- PENAMBAHAN TOMBOL BERITA ACARA DAN TOMBOL PERSETUJUAN -->
                                <!-- ============================================================= -->
                                <div class="flex items-center gap-2 w-full md:w-auto shrink-0 flex-wrap justify-end">
                                    <!-- TOMBOL BUKA BERITA ACARA DARI TIM HUKUM -->
                                    @if(!empty($item->file_berita_acara))
                                        <a href="{{ asset('storage/' . $item->file_berita_acara) }}" target="_blank" class="inline-flex items-center gap-1.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold text-xs px-3.5 py-2 rounded-xl border border-amber-400 shadow-sm transition">
                                            <span>📄</span> Buka Berita Acara Hukum
                                        </a>
                                    @endif

                                    <!-- TOMBOL AKSI SUPER ADMIN -->
                                    <button type="button" onclick="openSetujuModal('{{ $item->id }}', '{{ $item->kategori }}')" class="bg-emerald-50 hover:bg-emerald-500 text-emerald-600 hover:text-white px-4 py-2 rounded-xl text-xs font-bold transition">Setujui</button>
                                    <button type="button" onclick="openRevisiModal('{{ $item->id }}', '{{ $item->kategori }}')" class="bg-amber-50 hover:bg-amber-500 text-amber-600 hover:text-white px-4 py-2 rounded-xl text-xs font-bold transition">Revisi</button>
                                    <button type="button" onclick="openTolakModal('{{ $item->id }}', '{{ $item->kategori }}')" class="bg-red-50 hover:bg-red-500 text-red-600 hover:text-white px-4 py-2 rounded-xl text-xs font-bold transition">Tolak</button>
                                </div>

                            </div>
                        @empty
                            <div class="text-center bg-slate-50 rounded-2xl border border-slate-100 py-10 text-slate-500 font-medium">Tidak ada draf yang menunggu persetujuan.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- SECTION REKAP JADWAL -->
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

            <!-- SECTION BERITA -->
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
                                            @elseif($berita->status == 'revisi') <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase">Direvisi</span>
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

            <!-- SECTION LOG -->
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
                                        @elseif($log->aksi == 'Revisi') <span class="bg-amber-500/20 text-amber-400 px-2 py-1 rounded text-[10px] font-extrabold uppercase border border-amber-500/30">Revisi</span>
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

    <!-- MODALS KEBIJAKAN -->
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

    <div id="revisiModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl p-8 w-full max-w-md shadow-2xl animate-in zoom-in duration-200">
            <h3 class="font-extrabold text-xl mb-4 text-amber-600">Minta Revisi Dokumen</h3>
            <form id="formRevisi" method="POST" action="">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="revisi">
                <textarea name="alasan_penolakan" required rows="3" placeholder="Catat bagian mana yang perlu diperbaiki Admin..." class="w-full bg-amber-50/50 border border-amber-200 rounded-xl p-3 text-sm mb-6 outline-none focus:ring-2 focus:ring-amber-500 transition"></textarea>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeKebijakanModals()" class="px-6 py-2.5 bg-slate-100 rounded-xl font-bold text-slate-500 text-sm">Batal</button>
                    <button type="submit" class="bg-amber-500 text-white px-6 py-2.5 rounded-xl font-extrabold shadow-md text-sm">Kirim Catatan</button>
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
                <textarea name="alasan_penolakan" required rows="3" placeholder="Alasan penolakan mutlak..." class="w-full bg-red-50/50 border border-red-200 rounded-xl p-3 text-sm mb-6 outline-none focus:ring-2 focus:ring-red-500 transition"></textarea>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeKebijakanModals()" class="px-6 py-2.5 bg-slate-100 rounded-xl font-bold text-slate-500 text-sm">Batal</button>
                    <button type="submit" class="bg-red-500 text-white px-6 py-2.5 rounded-xl font-extrabold shadow-md text-sm">Kirim Penolakan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL REVIEW BERITA -->
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
                        <label id="labelAlasanTolak" class="block text-xs font-extrabold text-red-500 uppercase tracking-widest mb-2">Alasan Penolakan (Wajib jika menolak):</label>
                        <textarea name="alasan_penolakan" id="inputAlasanTolak" rows="2" class="w-full bg-white border border-red-200 rounded-xl p-3 text-sm focus:ring-2 outline-none" placeholder="Tuliskan alasan spesifik..."></textarea>
                    </div>

                    <div class="flex flex-col md:flex-row justify-end gap-3 w-full" id="areaTombolAksi">
                        <input type="hidden" name="status" id="inputStatusBerita" value="">
                        
                        <button type="button" onclick="toggleCatatanBerita('rejected')" id="btnToggleTolak" class="bg-red-100 hover:bg-red-200 text-red-700 px-6 py-3 rounded-xl font-bold transition order-3 md:order-1 w-full md:w-auto">Tolak</button>
                        
                        <button type="button" onclick="toggleCatatanBerita('revisi')" id="btnToggleRevisi" class="bg-amber-100 hover:bg-amber-200 text-amber-700 px-6 py-3 rounded-xl font-bold transition order-2 md:order-2 w-full md:w-auto">Minta Revisi</button>
                        
                        <button type="button" onclick="submitReviewBerita('realSubmit')" id="btnSubmitCatatan" class="hidden bg-slate-800 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition order-2 w-full md:w-auto">Kirim Catatan</button>
                        
                        <button type="button" onclick="submitReviewBerita('approved')" id="btnApproveBerita" class="bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg transition flex items-center justify-center gap-2 order-1 md:order-3 w-full md:w-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Setujui Publikasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SCRIPT INITIALIZATION -->
    <script>
        let myUploadsChart = null;
        const rawUploadsData = {!! json_encode($chartUploads ?? ['labels'=>[], 'all'=>['total'=>[], 'approved'=>[], 'rejected'=>[], 'pending'=>[]]]) !!};

        document.addEventListener("DOMContentLoaded", function() {
            // 1. Render Chart Views (Doughnut)
            const viewsCtx = document.getElementById('viewsChart');
            const viewsData = {!! json_encode($chartViews ?? ['labels'=>[], 'data'=>[]]) !!};
            
            if(viewsCtx && viewsData.labels && viewsData.labels.length > 0) {
                new Chart(viewsCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: viewsData.labels,
                        datasets: [{
                            label: 'Total Views',
                            data: viewsData.data,
                            backgroundColor: ['#4F46E5', '#10B981', '#F59E0B', '#EF4444'],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
                });
            }

            // 2. Inisialisasi awal Grafik Upload
            initUploadsChart('all');
        });

        function initUploadsChart(filter) {
            const uploadsCtx = document.getElementById('uploadsChart');
            if(!uploadsCtx || !rawUploadsData.labels || rawUploadsData.labels.length === 0) return;

            const dataSetToUse = rawUploadsData[filter];

            if (myUploadsChart) {
                myUploadsChart.destroy();
            }

            myUploadsChart = new Chart(uploadsCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: rawUploadsData.labels,
                    datasets: [
                        { label: 'Total Unggahan', data: dataSetToUse.total, backgroundColor: '#6366F1', borderRadius: 4 },
                        { label: 'Disetujui', data: dataSetToUse.approved, backgroundColor: '#10B981', borderRadius: 4 },
                        { label: 'Ditolak', data: dataSetToUse.rejected, backgroundColor: '#EF4444', borderRadius: 4 },
                        { label: 'Pending / Revisi', data: dataSetToUse.pending, backgroundColor: '#F59E0B', borderRadius: 4 }
                    ]
                },
                options: {
                    responsive: true, 
                    maintainAspectRatio: false,
                    scales: { x: { stacked: false }, y: { beginAtZero: true, ticks: { stepSize: 1 } } },
                    plugins: { legend: { display: true, position: 'bottom' } }
                }
            });
        }

        function updateUploadsChart() {
            const filter = document.getElementById('filterUploadsChart').value;
            initUploadsChart(filter);
        }

        // ======================= NAVIGATION LOGIC =======================
        function switchMenu(menuName) {
            const sections = ['manajemen', 'tinjauan', 'rekap_jadwal', 'log', 'berita', 'profil'];
            
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
                const metadata = {
                    'manajemen': ["Manajemen Akses & Kebijakan", "Kelola Admin dan tinjau seluruh draf kebijakan dari satu pintu."],
                    'tinjauan': ["Tinjauan Draf Kebijakan", "Daftar permohonan publikasi draf yang menunggu persetujuan Anda."],
                    'rekap_jadwal': ["Rekap Jadwal Pertemuan", "Pantau seluruh janji temu yang telah disetujui oleh tim operasional."],
                    'log': ["Log Aktivitas Persetujuan", "Pantau seluruh riwayat audit keputusan secara realtime."],
                    'berita': ["Tinjauan Artikel Jurnalistik", "Review dan kelola draf berita yang diajukan oleh Admin operasional."],
                    'profil': ["Profil & Keamanan", "Lengkapi identitas diri, kelola keamanan, dan unggah foto profil Anda."]
                };

                if (metadata[menuName]) {
                    headerTitle.innerText = metadata[menuName][0];
                    headerDesc.innerText = metadata[menuName][1];
                }
            }
        }

        // ======================= MODAL KEBIJAKAN LOGIC =======================
        function openSetujuModal(id, kategori) {
            const modal = document.getElementById('setujuModal');
            const form = document.getElementById('formSetuju');
            if (modal && form) { modal.classList.replace('hidden', 'flex'); form.action = `/super-admin/kebijakan/review/${kategori}/${id}`; }
        }
        function openTolakModal(id, kategori) {
            const modal = document.getElementById('tolakModal');
            const form = document.getElementById('formTolak');
            if (modal && form) { modal.classList.replace('hidden', 'flex'); form.action = `/super-admin/kebijakan/review/${kategori}/${id}`; }
        }
        function openRevisiModal(id, kategori) {
            const modal = document.getElementById('revisiModal');
            const form = document.getElementById('formRevisi');
            if (modal && form) { modal.classList.replace('hidden', 'flex'); form.action = `/super-admin/kebijakan/review/${kategori}/${id}`; }
        }
        function closeKebijakanModals() {
            ['setujuModal', 'tolakModal', 'revisiModal'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.classList.replace('flex', 'hidden');
            });
        }

        // ======================= MODAL BERITA LOGIC =======================
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
            
            // Reset UI State Modals
            document.getElementById('alasanTolakContainer').classList.add('hidden');
            document.getElementById('btnSubmitCatatan').classList.add('hidden');
            document.getElementById('inputAlasanTolak').value = "";
            document.getElementById('inputAlasanTolak').required = false;

            if(document.getElementById('areaTombolAksi')) {
                document.getElementById('areaTombolAksi').classList.remove('hidden');
                document.getElementById('btnToggleTolak').classList.remove('hidden');
                document.getElementById('btnToggleRevisi').classList.remove('hidden');
                document.getElementById('btnApproveBerita').classList.remove('hidden');
            }

            document.getElementById('reviewBeritaModal').classList.replace('hidden', 'flex');
        }

        function closeReviewBeritaModal() {
            document.getElementById('reviewBeritaModal').classList.replace('flex', 'hidden');
        }

        let tempStatusBerita = '';

        function toggleCatatanBerita(status) {
            tempStatusBerita = status;
            document.getElementById('alasanTolakContainer').classList.remove('hidden');
            
            const labelTolak = document.getElementById('labelAlasanTolak');
            const btnSubmitCatatan = document.getElementById('btnSubmitCatatan');
            const inputAlasan = document.getElementById('inputAlasanTolak');
            
            if(status === 'revisi') {
                labelTolak.innerText = "Catatan Revisi (Wajib):";
                labelTolak.className = "block text-xs font-extrabold text-amber-500 uppercase tracking-widest mb-2";
                btnSubmitCatatan.className = "bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition order-2 w-full md:w-auto";
                btnSubmitCatatan.innerText = "Kirim Catatan Revisi";
                inputAlasan.className = "w-full bg-amber-50/50 border border-amber-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-amber-500 outline-none";
                inputAlasan.placeholder = "Catat bagian mana yang perlu diperbaiki oleh Admin...";
            } else {
                labelTolak.innerText = "Alasan Penolakan (Wajib jika menolak mutlak):";
                labelTolak.className = "block text-xs font-extrabold text-red-500 uppercase tracking-widest mb-2";
                btnSubmitCatatan.className = "bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition order-2 w-full md:w-auto";
                btnSubmitCatatan.innerText = "Kirim Penolakan";
                inputAlasan.className = "w-full bg-red-50/50 border border-red-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-red-500 outline-none";
                inputAlasan.placeholder = "Alasan spesifik penolakan...";
            }

            document.getElementById('btnToggleTolak').classList.add('hidden');
            document.getElementById('btnToggleRevisi').classList.add('hidden');
            document.getElementById('btnApproveBerita').classList.add('hidden');
            
            btnSubmitCatatan.classList.remove('hidden');
            inputAlasan.required = true;
        }

        function submitReviewBerita(action) {
            if(action === 'approved') {
                document.getElementById('inputStatusBerita').value = 'approved';
            } else {
                document.getElementById('inputStatusBerita').value = tempStatusBerita;
            }
            document.getElementById('formReviewBerita').submit();
        }
    </script>
</body>
</html>