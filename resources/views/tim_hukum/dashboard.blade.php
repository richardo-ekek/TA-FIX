<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel Tim Hukum & Legalitas - Portal SPA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800 min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-72 bg-slate-900 text-slate-300 flex flex-col shadow-2xl z-20 hidden md:flex shrink-0">
        <div class="p-6 border-b border-slate-800 flex items-center gap-3">
            <div class="bg-amber-600 rounded-lg overflow-hidden w-10 h-10 flex items-center justify-center font-bold text-white text-lg shadow-md">
                @if(auth()->user()->foto_profil)
                    <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" class="w-full h-full object-cover">
                @else
                    {{ substr(auth()->user()->name, 0, 1) }}
                @endif
            </div>
            <div>
                <h1 class="text-white font-bold text-base leading-tight">Tim Hukum & Legal</h1>
                <p class="text-xs text-amber-400 font-medium">Verifikator Dokumen</p>
            </div>
        </div>
        
        <nav class="flex-1 p-4 space-y-2">
            <button type="button" onclick="switchMenu('antrean')" id="btn-antrean" class="w-full flex items-center justify-between px-4 py-3 rounded-xl bg-amber-600 text-white shadow-lg shadow-amber-900/50 font-bold transition text-sm">
                <span class="flex items-center gap-2.5">📋 Antrean Verifikasi</span>
                @if($antrean->count() > 0)
                    <span class="bg-white text-amber-700 text-[10px] font-black px-2 py-0.5 rounded-full">{{ $antrean->count() }}</span>
                @endif
            </button>
            <button type="button" onclick="switchMenu('riwayat')" id="btn-riwayat" class="w-full flex items-center gap-2.5 px-4 py-3 rounded-xl hover:bg-slate-800 transition text-slate-300 hover:text-white text-sm font-medium">
                <span>🗂️ Riwayat Verifikasi</span>
            </button>
            <button type="button" onclick="switchMenu('profil')" id="btn-profil" class="w-full flex items-center gap-2.5 px-4 py-3 rounded-xl hover:bg-slate-800 transition text-slate-300 hover:text-white text-sm font-medium">
                <span>👤 Profil & Keamanan</span>
            </button>
        </nav>

        <div class="p-4 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="flex justify-center items-center gap-2 w-full bg-slate-800 hover:bg-red-500/20 hover:text-red-400 py-3 rounded-xl text-sm font-bold transition">Kelola Keluar (Logout)</button>
            </form>
        </div>
    </aside>

    <!-- KONTEN UTAMA -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <!-- HEADER -->
        <header class="bg-white px-8 py-5 border-b border-slate-200 shadow-sm flex justify-between items-center z-10 shrink-0">
            <div>
                <h2 id="header-title" class="text-2xl font-extrabold text-slate-800">Antrean Verifikasi Legalitas</h2>
                <p id="header-desc" class="text-sm text-slate-500 mt-1">Periksa kesesuaian pasal, regulasi, dan draf kerja sama sebelum diteruskan ke pimpinan.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-extrabold bg-amber-50 text-amber-700 border border-amber-200">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span> Mode Verifikator Hukum
                </span>
            </div>
        </header>

        <div class="flex-1 p-8 overflow-y-auto bg-slate-50 custom-scrollbar">
            
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl font-semibold shadow-sm flex items-center gap-3">
                    <span class="text-xl">✅</span> <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl font-semibold shadow-sm flex items-center gap-3">
                    <span class="text-xl">⚠️</span> <div>{{ session('error') }}</div>
                </div>
            @endif

            <!-- ========================================================== -->
            <!-- SECTION 1: ANTREAN VERIFIKASI (PENDING HUKUM)              -->
            <!-- ========================================================== -->
            <div id="section-antrean">
                <div class="space-y-4">
                    @forelse($antrean as $item)
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 transition hover:border-amber-300 relative overflow-hidden group">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-3">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-lg text-xs font-black uppercase tracking-wider border border-amber-200">{{ $item->tipe_dokumen }}</span>
                                    <span class="text-xs font-bold text-slate-400">&bull; Diajukan oleh Admin: <strong class="text-slate-700">{{ $item->admin->name ?? 'Admin' }}</strong></span>
                                    <span class="text-xs font-bold text-slate-400">&bull; {{ $item->updated_at->format('d M Y, H:i') }} WIB</span>
                                </div>
                                <span class="bg-yellow-100 text-yellow-800 text-[11px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider w-fit">Menunggu Review Hukum</span>
                            </div>

                            <h3 class="text-lg font-bold text-slate-800 mb-1">{{ $item->judul }}</h3>
                            @if(isset($item->nomor_kebijakan)) 
                                <p class="text-xs font-mono text-slate-500 mb-3">Nomor Dokumen: <span class="font-bold text-slate-700">{{ $item->nomor_kebijakan }}</span></p> 
                            @endif

                            <!-- Tampilkan Badge Jumlah Revisi Jika Dokumen Ini Sudah Pernah Direvisi Sebelumnya -->
                            @if($item->revisi_ke > 0)
                                <div class="mb-4 bg-purple-50 border border-purple-200 p-3 rounded-xl text-xs text-purple-900">
                                    <div class="font-extrabold flex items-center gap-1.5 mb-1">
                                        <span>🔄</span> Dokumen Hasil Perbaikan (Total: {{ $item->revisi_ke }}x Revisi Sebelum Ini):
                                    </div>
                                    <p class="font-mono text-[11px] font-semibold text-purple-700">{{ $item->riwayat_revisi }}</p>
                                </div>
                            @endif

                            <!-- DATA RAHASIA UNTUK MODAL DETAIL -->
                            <div id="data-doc-{{ $item->id }}" class="hidden"
                                data-tipe="{{ $item->tipe_dokumen }}" data-judul="{{ htmlspecialchars($item->judul, ENT_QUOTES) }}"
                                data-kategori="{{ $item->kategori_param }}" data-nomor="{{ $item->nomor_kebijakan ?? '-' }}"
                                data-tahun="{{ $item->tahun ?? '-' }}" data-jenis="{{ $item->jenis ?? $item->jenis_kebijakan ?? '-' }}"
                                data-satker="{{ $item->satker_kemlu ?? '-' }}" data-external="{{ $item->instansi_external ?? '-' }}"
                                data-instansi="{{ htmlspecialchars($item->instansi ?? '-', ENT_QUOTES) }}"
                                data-tglsah="{{ $item->tanggal_disahkan ? \Carbon\Carbon::parse($item->tanggal_disahkan)->format('d M Y') : '-' }}"
                                data-tglakhir="{{ $item->tanggal_berakhir ? \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d M Y') : '-' }}"
                                data-keterangan="{{ htmlspecialchars($item->keterangan ?? '-', ENT_QUOTES) }}"
                                data-tautan="{{ $item->tautan ?? '' }}"
                                data-pembuat="{{ $item->admin->name ?? 'Admin' }}"
                                data-statustext="DALAM PROSES TINJAUAN HUKUM">
                            </div>

                            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3 flex-wrap">
                                <button onclick="openDetailModal('{{ $item->id }}')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-4 py-2.5 rounded-xl text-xs transition flex items-center gap-1.5">
                                    <span>🔍</span> Lihat Detail & Isi Dokumen
                                </button>
                                <button onclick="openReviewModal('{{ $item->id }}', '{{ $item->kategori_param }}', '{{ addslashes($item->judul) }}')" class="bg-amber-600 hover:bg-amber-700 text-white font-extrabold px-5 py-2.5 rounded-xl text-xs shadow-md transition flex items-center gap-1.5">
                                    <span>⚖️</span> Proses Verifikasi Legalitas
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center text-slate-400">
                            <div class="text-4xl mb-3">📭</div>
                            <h4 class="font-bold text-base text-slate-600">Antrean Verifikasi Kosong</h4>
                            <p class="text-xs text-slate-400 mt-1">Seluruh dokumen dari Admin telah selesai diperiksa atau belum ada pengajuan baru.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- ========================================================== -->
            <!-- SECTION 2: RIWAYAT VERIFIKASI DOKUMEN                      -->
            <!-- ========================================================== -->
            <div id="section-riwayat" class="hidden">
                <!-- Filter Riwayat -->
                <div class="flex items-center justify-between mb-6 gap-3 flex-wrap bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <span>Daftar Dokumen Yang Telah Diproses</span>
                        <span class="bg-slate-100 text-slate-700 text-xs px-2.5 py-0.5 rounded-full font-extrabold">{{ $riwayat->count() }}</span>
                    </h3>
                    <select id="filterRiwayatHukum" onchange="filterRiwayat()" class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-xs font-bold text-slate-700 outline-none focus:ring-2 focus:ring-amber-500 cursor-pointer">
                        <option value="all">Semua Status Riwayat</option>
                        <option value="revisi_hukum">Dikembalikan / Direvisi Tim Hukum</option>
                        <option value="pending_superadmin">Diteruskan ke Pimpinan (Menunggu Pengesahan)</option>
                        <option value="approved">Telah Disahkan Pimpinan (Aktif)</option>
                    </select>
                </div>

                <div class="space-y-4">
                    @forelse($riwayat as $item)
                        <div class="card-riwayat bg-white rounded-2xl shadow-sm border border-slate-200 p-6 transition hover:border-slate-300 relative" data-status="{{ $item->status }}">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-2">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded text-[10px] font-black uppercase tracking-widest border border-slate-200">{{ $item->tipe_dokumen }}</span>
                                    <span class="text-xs font-bold text-slate-400">&bull; Diproses: {{ $item->updated_at->format('d M Y, H:i') }} WIB</span>
                                </div>

                                <!-- BADGE STATUS KEPUTUSAN TIM HUKUM -->
                                @if($item->status == 'revisi_hukum' || $item->status == 'revisi') 
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider w-fit">Dikembalikan (Minta Revisi)</span>
                                @elseif($item->status == 'pending_superadmin') 
                                    <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider w-fit">Lolos Legal &bull; Di Pimpinan</span>
                                @elseif(in_array($item->status, ['approved', 'aktif'])) 
                                    <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider w-fit">Disahkan Pimpinan &bull; Aktif</span>
                                @elseif(in_array($item->status, ['rejected', 'tidak aktif'])) 
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider w-fit">Ditolak / Tidak Aktif</span>
                                @else
                                    <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider w-fit">{{ strtoupper(str_replace('_', ' ', $item->status)) }}</span>
                                @endif
                            </div>

                            <h4 class="font-bold text-slate-800 text-base mb-1">{{ $item->judul }}</h4>
                            @if(isset($item->nomor_kebijakan)) 
                                <p class="text-xs font-mono text-slate-500 mb-3">No: {{ $item->nomor_kebijakan }}</p> 
                            @endif

                            <!-- RIWAYAT AUDIT AKTOR -->
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 text-xs text-slate-600 space-y-1 mb-3">
                                <p>👤 <strong>Admin Pengaju:</strong> {{ $item->admin->name ?? 'Admin' }}</p>
                                <p>⚖️ <strong>Verifikator Hukum:</strong> {{ $item->timHukum->name ?? 'Anda / Tim Hukum' }}</p>
                                @if($item->superAdmin)
                                    <p>👑 <strong>Pengesah Akhir:</strong> {{ $item->superAdmin->name }}</p>
                                @endif
                            </div>

                            <!-- LOG REVISI KRONOLOGIS -->
                            @if($item->revisi_ke > 0)
                                <div class="bg-purple-50/70 border border-purple-200 p-3 rounded-xl text-xs text-purple-900 mb-3">
                                    <strong class="block text-[10px] uppercase font-black tracking-widest text-purple-700 mb-1">🔄 Jejak Revisi Kronologis ({{ $item->revisi_ke }}x Revisi):</strong>
                                    <p class="font-mono text-[11px] font-semibold text-purple-800">{{ $item->riwayat_revisi }}</p>
                                </div>
                            @endif

                            <!-- CATATAN / ALASAN TIM HUKUM -->
                            @if($item->alasan_penolakan)
                                <div class="bg-blue-50 border border-blue-200 p-3 rounded-xl text-xs text-blue-900">
                                    <strong class="block text-[10px] uppercase font-black tracking-widest text-blue-700 mb-1">📝 Catatan Perbaikan Hukum yang Anda Kirimkan:</strong>
                                    <p class="italic font-medium leading-relaxed">"{{ $item->alasan_penolakan }}"</p>
                                </div>
                            @elseif($item->keterangan_tambahan)
                                <div class="bg-emerald-50 border border-emerald-200 p-3 rounded-xl text-xs text-emerald-900">
                                    <strong class="block text-[10px] uppercase font-black tracking-widest text-emerald-700 mb-1">✅ Catatan Lolos Legalitas:</strong>
                                    <p class="font-medium leading-relaxed">{{ $item->keterangan_tambahan }}</p>
                                </div>
                            @endif

                            <!-- DATA RAHASIA UNTUK MODAL DETAIL -->
                            <div id="data-doc-{{ $item->id }}" class="hidden"
                                data-tipe="{{ $item->tipe_dokumen }}" data-judul="{{ htmlspecialchars($item->judul, ENT_QUOTES) }}"
                                data-kategori="{{ $item->kategori_param }}" data-nomor="{{ $item->nomor_kebijakan ?? '-' }}"
                                data-tahun="{{ $item->tahun ?? '-' }}" data-jenis="{{ $item->jenis ?? $item->jenis_kebijakan ?? '-' }}"
                                data-satker="{{ $item->satker_kemlu ?? '-' }}" data-external="{{ $item->instansi_external ?? '-' }}"
                                data-instansi="{{ htmlspecialchars($item->instansi ?? '-', ENT_QUOTES) }}"
                                data-tglsah="{{ $item->tanggal_disahkan ? \Carbon\Carbon::parse($item->tanggal_disahkan)->format('d M Y') : '-' }}"
                                data-tglakhir="{{ $item->tanggal_berakhir ? \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d M Y') : '-' }}"
                                data-keterangan="{{ htmlspecialchars($item->keterangan ?? '-', ENT_QUOTES) }}"
                                data-tautan="{{ $item->tautan ?? '' }}"
                                data-pembuat="{{ $item->admin->name ?? 'Admin' }}"
                                data-statustext="{{ strtoupper(str_replace('_', ' ', $item->status)) }}">
                            </div>

                            <div class="mt-4 pt-3 border-t border-slate-100 flex justify-end">
                                <button onclick="openDetailModal('{{ $item->id }}')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-4 py-2 rounded-xl text-xs transition flex items-center gap-1.5">
                                    <span>🔍</span> Lihat Detail Dokumen
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center text-slate-400">
                            <div class="text-4xl mb-3">🗂️</div>
                            <h4 class="font-bold text-base text-slate-600">Belum Ada Riwayat</h4>
                            <p class="text-xs text-slate-400 mt-1">Anda belum melakukan proses ulasan atau verifikasi pada dokumen kebijakan apa pun.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- ========================================================== -->
            <!-- SECTION 3: PROFIL & KEAMANAN AKUN                          -->
            <!-- ========================================================== -->
            <div id="section-profil" class="hidden">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8 max-w-3xl">
                    <h3 class="text-xl font-extrabold text-slate-800 mb-6">Identitas Akun & Foto Profil</h3>
                    
                    <form action="{{ route('profile.update_foto') }}" method="POST" enctype="multipart/form-data" class="mb-8 flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        @csrf
                        <div class="shrink-0 w-16 h-16 rounded-full overflow-hidden bg-amber-100 border-2 border-white shadow-sm flex items-center justify-center text-xl font-bold text-amber-700">
                            @if(auth()->user()->foto_profil)
                                <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" class="w-full h-full object-cover">
                            @else
                                {{ substr(auth()->user()->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Pilih Foto Baru (Maksimal 2MB)</label>
                            <input type="file" name="foto_profil" required accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-amber-100 file:text-amber-800 hover:file:bg-amber-200 transition">
                        </div>
                        <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-6 rounded-xl transition shadow-md text-sm">Update Foto</button>
                    </form>

                    <div class="mb-8 grid grid-cols-2 gap-4 bg-slate-50 p-6 rounded-2xl border border-slate-100">
                        <div><span class="block text-[10px] font-bold text-slate-400 uppercase">Nama Terdaftar</span><span class="font-extrabold text-slate-800">{{ auth()->user()->name }}</span></div>
                        <div><span class="block text-[10px] font-bold text-slate-400 uppercase">Email Terdaftar</span><span class="font-extrabold text-slate-800">{{ auth()->user()->email }}</span></div>
                        <div class="col-span-2"><span class="block text-[10px] font-bold text-slate-400 uppercase">Hak Akses & Peran</span><span class="font-extrabold text-amber-600 uppercase">{{ auth()->user()->role }}</span></div>
                    </div>

                    <h3 class="text-xl font-extrabold text-slate-800 mb-6 border-t pt-6">Lengkapi Data Pegawai</h3>
                    <form action="{{ route('profile.custom.update_detail') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-amber-500 outline-none"></div>
                            
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nomor Induk Pegawai (NIP)</label>
                            <input type="text" name="nip" value="{{ auth()->user()->nip }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Masukkan NIP..."></div>
                            
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ auth()->user()->tanggal_lahir }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-amber-500 outline-none"></div>
                            
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jabatan Fungsional/Struktural</label>
                            <input type="text" name="jabatan" value="{{ auth()->user()->jabatan }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Contoh: Perancang Peraturan / Analis Hukum"></div>

                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nomor Telepon/WhatsApp</label>
                            <input type="text" name="no_telp" value="{{ auth()->user()->no_telp }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-amber-500 outline-none" placeholder="0812345..."></div>
                            
                            <div class="md:col-span-2"><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Alamat Domisili</label>
                            <textarea name="alamat" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-amber-500 outline-none">{{ auth()->user()->alamat }}</textarea></div>
                        </div>
                        <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 px-6 rounded-xl transition mt-2 shadow-md text-sm">Simpan Data Pegawai</button>
                    </form>

                    <h3 class="text-xl font-extrabold text-slate-800 mb-6 border-t pt-6 mt-8">Ganti Kata Sandi Keamanan</h3>
                    <form action="{{ route('password.custom.update') }}" method="POST" class="space-y-4">
                        @csrf
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kata Sandi Saat Ini</label><input type="password" name="current_password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-amber-500 outline-none">@error('current_password') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror</div>
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kata Sandi Baru</label><input type="password" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Minimal 8 Karakter">@error('password') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror</div>
                            <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Konfirmasi Kata Sandi Baru</label><input type="password" name="password_confirmation" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-amber-500 outline-none"></div>
                        </div>
                        <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-xl transition mt-4 shadow-md text-sm">Perbarui Kata Sandi</button>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <!-- ================================================================= -->
    <!-- MODAL DETAIL DOKUMEN                                              -->
    <!-- ================================================================= -->
    <div id="detailModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="bg-gradient-to-r from-slate-900 to-amber-800 p-6 flex justify-between items-center shrink-0 text-white">
                <div class="flex items-center gap-3">
                    <div class="bg-white/10 p-2.5 rounded-xl text-xl">📄</div>
                    <div>
                        <h3 class="text-lg font-extrabold" id="dtl-tipe">Detail Dokumen Kebijakan</h3>
                        <p class="text-amber-200 text-xs" id="dtl-status"></p>
                    </div>
                </div>
                <button type="button" onclick="closeModals()" class="text-slate-400 hover:text-white font-bold text-xl">&times;</button>
            </div>
            
            <div class="p-6 overflow-y-auto space-y-4 bg-slate-50/50 custom-scrollbar flex-1 text-sm">
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Perihal / Judul Dokumen</span>
                    <p class="font-extrabold text-slate-800 text-base" id="dtl-judul"></p>
                </div>

                <!-- Detail Khusus MoU/PKS -->
                <div id="dtl-box-mou" class="hidden grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/60"><span class="block text-[10px] font-bold text-slate-400 uppercase">Jenis Kerja Sama</span><strong class="text-slate-700" id="dtl-mou-jenis"></strong></div>
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/60"><span class="block text-[10px] font-bold text-slate-400 uppercase">Satker Kemlu</span><strong class="text-slate-700" id="dtl-mou-satker"></strong></div>
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/60"><span class="block text-[10px] font-bold text-slate-400 uppercase">Mitra External (K/L/I)</span><strong class="text-slate-700" id="dtl-mou-external"></strong></div>
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/60"><span class="block text-[10px] font-bold text-slate-400 uppercase">Masa Berlaku</span><strong class="text-slate-700"><span id="dtl-mou-tglsah"></span> s.d. <span id="dtl-mou-tglakhir"></span></strong></div>
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/60 sm:col-span-2"><span class="block text-[10px] font-bold text-slate-400 uppercase">Keterangan / Ruang Lingkup</span><p class="text-slate-600 mt-1" id="dtl-mou-ket"></p></div>
                </div>

                <!-- Detail Khusus TIK -->
                <div id="dtl-box-tik" class="hidden grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/60"><span class="block text-[10px] font-bold text-slate-400 uppercase">Jenis Kebijakan</span><strong class="text-slate-700" id="dtl-tik-jenis"></strong></div>
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/60"><span class="block text-[10px] font-bold text-slate-400 uppercase">Nomor & Tahun</span><strong class="text-slate-700"><span id="dtl-tik-nomor"></span> (Thn: <span id="dtl-tik-tahun"></span>)</strong></div>
                    <div id="dtl-box-instansi" class="hidden bg-white p-3.5 rounded-xl border border-slate-200/60 sm:col-span-2"><span class="block text-[10px] font-bold text-slate-400 uppercase">Instansi Penerbit</span><strong class="text-slate-700" id="dtl-tik-instansi"></strong></div>
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200/60 sm:col-span-2 flex items-center justify-between">
                        <div><span class="block text-[10px] font-bold text-slate-400 uppercase">Tautan Berkas (Google Drive/Cloud)</span><span class="text-xs text-slate-500 truncate max-w-[250px] inline-block" id="dtl-tik-tautan-text"></span></div>
                        <a href="" id="dtl-tik-tautan-btn" target="_blank" class="bg-amber-600 hover:bg-amber-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">Buka Dokumen Asli →</a>
                    </div>
                </div>

                <div class="bg-slate-100 p-3.5 rounded-xl border border-slate-200 text-xs">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase">Diajukan Oleh:</span>
                    <strong class="text-slate-700" id="dtl-pembuat"></strong>
                </div>
            </div>

            <div class="p-5 border-t bg-white flex justify-end">
                <button type="button" onclick="closeModals()" class="bg-slate-800 hover:bg-slate-900 text-white px-6 py-2.5 rounded-xl text-xs font-bold transition">Tutup Jendela</button>
            </div>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- MODAL PROSES VERIFIKASI HUKUM                                     -->
    <!-- ================================================================= -->
    <div id="reviewModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="bg-gradient-to-r from-amber-600 to-amber-700 p-6 text-white shrink-0 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-extrabold">Keputusan Verifikasi Hukum</h3>
                    <p class="text-amber-100 text-xs truncate max-w-md" id="rev-judul-doc">Judul Dokumen</p>
                </div>
                <button type="button" onclick="closeModals()" class="text-white/70 hover:text-white font-bold text-xl">&times;</button>
            </div>

            <form id="formReviewHukum" method="POST" action="" class="p-6 space-y-5 bg-white overflow-y-auto flex-1">
                @csrf
                @method('PATCH')

                <div class="bg-amber-50 border border-amber-200 p-4 rounded-2xl text-xs text-amber-900 leading-relaxed">
                    ⚖️ <strong>SOP Legalitas:</strong> Pastikan seluruh klausul tidak bertentangan dengan regulasi nasional maupun perjanjian internasional sebelum disetujui.
                </div>

                <!-- PILIHAN KEPUTUSAN -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tentukan Keputusan Legalitas <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="relative flex cursor-pointer rounded-xl border border-slate-200 bg-slate-50 p-3.5 shadow-sm hover:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-500 transition">
                            <input type="radio" name="status" value="approved" required class="sr-only peer" onchange="toggleCatatanHukum(this.value)">
                            <div class="flex w-full items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="text-xl">✅</div>
                                    <div>
                                        <p class="text-xs font-extrabold text-slate-800">Lolos Verifikasi</p>
                                        <p class="text-[10px] text-slate-500">Teruskan ke Pimpinan</p>
                                    </div>
                                </div>
                                <div class="h-4 w-4 rounded-full border border-slate-300 peer-checked:border-emerald-600 peer-checked:bg-emerald-600 flex items-center justify-center text-white text-[9px] font-bold">✓</div>
                            </div>
                            <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-emerald-600 pointer-events-none"></div>
                        </label>

                        <label class="relative flex cursor-pointer rounded-xl border border-slate-200 bg-slate-50 p-3.5 shadow-sm hover:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500 transition">
                            <input type="radio" name="status" value="revisi" required class="sr-only peer" onchange="toggleCatatanHukum(this.value)">
                            <div class="flex w-full items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="text-xl">📝</div>
                                    <div>
                                        <p class="text-xs font-extrabold text-slate-800">Minta Perbaikan</p>
                                        <p class="text-[10px] text-slate-500">Kembalikan ke Admin</p>
                                    </div>
                                </div>
                                <div class="h-4 w-4 rounded-full border border-slate-300 peer-checked:border-blue-600 peer-checked:bg-blue-600 flex items-center justify-center text-white text-[9px] font-bold">✓</div>
                            </div>
                            <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-blue-600 pointer-events-none"></div>
                        </label>
                    </div>
                </div>

                <!-- KOLOM CATATAN HUKUM -->
                <div>
                    <label id="label-catatan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Catatan Legal / Alasan Revisi <span id="wajib-badge" class="text-red-500 hidden">*</span>
                    </label>
                    <textarea name="catatan_hukum" id="input-catatan" rows="4" placeholder="Tuliskan pasal yang kurang tepat atau catatan tambahan untuk pimpinan..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-amber-500 outline-none leading-relaxed"></textarea>
                    <p class="text-[10px] text-slate-400 mt-1 italic">Catatan ini akan tersimpan permanen di dalam riwayat audit trail dokumen.</p>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" onclick="closeModals()" class="px-5 py-2.5 bg-slate-100 rounded-xl font-bold text-slate-500 text-xs hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-2.5 rounded-xl font-extrabold text-xs shadow-lg transition flex items-center gap-1.5">
                        <span>⚖️</span> Simpan Keputusan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT INITIALIZATION -->
    <script>
        // FUNGSI SWITCH MENU SPA
        function switchMenu(menuName) {
            const sections = ['antrean', 'riwayat', 'profil'];
            const titles = {
                'antrean': ['Antrean Verifikasi Legalitas', 'Periksa kesesuaian pasal, regulasi, dan draf kerja sama sebelum diteruskan ke pimpinan.'],
                'riwayat': ['Riwayat Verifikasi Dokumen', 'Daftar rekam jejak dokumen yang telah Anda ulas atau selesaikan.'],
                'profil':  ['Profil & Keamanan Akun', 'Lengkapi identitas diri dan perbarui kata sandi keamanan Anda.']
            };

            sections.forEach(section => {
                const el = document.getElementById('section-' + section);
                const btn = document.getElementById('btn-' + section);
                if (!el || !btn) return;

                if (section === menuName) {
                    el.classList.remove('hidden');
                    btn.className = "w-full flex items-center justify-between px-4 py-3 rounded-xl bg-amber-600 text-white shadow-lg shadow-amber-900/50 font-bold transition text-sm";
                } else {
                    el.classList.add('hidden');
                    btn.className = "w-full flex items-center gap-2.5 px-4 py-3 rounded-xl hover:bg-slate-800 transition text-slate-300 hover:text-white text-sm font-medium";
                }
            });

            document.getElementById('header-title').innerText = titles[menuName][0];
            document.getElementById('header-desc').innerText = titles[menuName][1];
        }

        // FUNGSI LIHAT DETAIL DOKUMEN
        function openDetailModal(id) {
            const data = document.getElementById('data-doc-' + id).dataset;
            
            document.getElementById('dtl-tipe').innerText = data.tipe;
            document.getElementById('dtl-status').innerText = 'Status: ' + data.statustext;
            document.getElementById('dtl-judul').innerText = data.judul;
            document.getElementById('dtl-pembuat').innerText = data.pembuat;

            document.getElementById('dtl-box-mou').classList.add('hidden');
            document.getElementById('dtl-box-tik').classList.add('hidden');
            document.getElementById('dtl-box-instansi').classList.add('hidden');

            if (data.kategori === 'mou') {
                document.getElementById('dtl-box-mou').classList.remove('hidden');
                document.getElementById('dtl-mou-jenis').innerText = data.jenis;
                document.getElementById('dtl-mou-satker').innerText = data.satker;
                document.getElementById('dtl-mou-external').innerText = data.external;
                document.getElementById('dtl-mou-tglsah').innerText = data.tglsah !== '-' ? data.tglsah : 'Belum diset';
                document.getElementById('dtl-mou-tglakhir').innerText = data.tglakhir !== '-' ? data.tglakhir : 'Belum diset';
                document.getElementById('dtl-mou-ket').innerText = data.keterangan !== '-' ? data.keterangan : 'Tidak ada keterangan.';
            } else {
                document.getElementById('dtl-box-tik').classList.remove('hidden');
                document.getElementById('dtl-tik-jenis').innerText = data.jenis;
                document.getElementById('dtl-tik-nomor').innerText = data.nomor;
                document.getElementById('dtl-tik-tahun').innerText = data.tahun;
                document.getElementById('dtl-tik-tautan-text').innerText = data.tautan || 'Tidak ada tautan';
                
                const btnLink = document.getElementById('dtl-tik-tautan-btn');
                if (data.tautan && data.tautan !== '-' && data.tautan !== '') {
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

            document.getElementById('detailModal').classList.replace('hidden', 'flex');
        }

        // FUNGSI BUKA MODAL REVIEW HUKUM
        function openReviewModal(id, kategori, judul) {
            document.getElementById('rev-judul-doc').innerText = judul;
            document.getElementById('formReviewHukum').action = `/tim-hukum/review/${kategori}/${id}`;
            
            // Reset form input
            document.querySelectorAll('input[name="status"]').forEach(el => el.checked = false);
            document.getElementById('input-catatan').value = '';
            toggleCatatanHukum('');

            document.getElementById('reviewModal').classList.replace('hidden', 'flex');
        }

        function toggleCatatanHukum(val) {
            const badge = document.getElementById('wajib-badge');
            const input = document.getElementById('input-catatan');
            if (val === 'revisi') {
                badge.classList.remove('hidden');
                input.required = true;
                input.placeholder = "Wajib jelaskan pasal, klausul, atau regulasi apa yang bertentangan sehingga harus direvisi...";
            } else {
                badge.classList.add('hidden');
                input.required = false;
                input.placeholder = "Opsional: berikan catatan legalitas untuk pertimbangan pimpinan...";
            }
        }

        function closeModals() {
            document.getElementById('detailModal').classList.replace('flex', 'hidden');
            document.getElementById('reviewModal').classList.replace('flex', 'hidden');
        }

        window.onclick = function(e) {
            if (e.target.classList.contains('fixed')) { closeModals(); }
        }

        // FUNGSI FILTER RIWAYAT HUKUM
        function filterRiwayat() {
            const filter = document.getElementById('filterRiwayatHukum').value;
            const cards = document.querySelectorAll('.card-riwayat');

            cards.forEach(card => {
                const status = card.getAttribute('data-status');
                if (filter === 'all' || 
                    status === filter ||
                    (filter === 'revisi_hukum' && (status === 'revisi' || status === 'revisi_hukum')) ||
                    (filter === 'approved' && (status === 'approved' || status === 'aktif'))) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>