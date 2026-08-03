<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Layanan & Portal Berita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen pb-12">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        
        <div class="flex justify-between items-center mb-6">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest bg-white px-4 py-2 rounded-full border border-slate-200 shadow-sm">Portal Terpadu Kemlu</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-white hover:bg-red-50 text-red-600 border border-red-100 px-6 py-2 rounded-xl text-sm font-bold transition shadow-sm flex items-center gap-2">Logout</button>
            </form>
        </div>

        <div class="flex flex-col md:flex-row gap-6 items-stretch mb-8">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center justify-center w-full md:w-64 text-center">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-28 object-contain">
            </div>
            <div class="flex-1 bg-gradient-to-br from-indigo-600 to-blue-700 rounded-[2.5rem] p-10 text-white relative overflow-hidden flex flex-col justify-center shadow-xl shadow-blue-900/20">
                <div class="relative z-10">
                    <h1 class="text-3xl md:text-4xl font-extrabold mb-3">Halo, {{ auth()->user()->name ?? 'Pengguna' }}! 👋</h1>
                    <p class="text-blue-100 text-lg max-w-xl leading-relaxed">Pantau dokumen kebijakan, jadwalkan janji temu, dan baca berita terbaru secara instan.</p>
                </div>
                <div class="mt-8 relative z-10">
                    <a href="{{ route('appointment.create') }}" class="bg-white text-blue-700 hover:bg-blue-50 px-8 py-3.5 rounded-2xl font-bold transition inline-flex items-center gap-2 shadow-lg">
                        <span>+</span> Ajukan Appointment Baru
                    </a>
                </div>
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl font-semibold shadow-sm w-full">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-wrap gap-3 mb-8 bg-white p-2 rounded-2xl shadow-sm border border-slate-200 w-fit mx-auto md:mx-0">
            <button onclick="switchMainTab('layanan')" id="btn-main-layanan" class="px-8 py-3 rounded-xl font-extrabold text-sm transition bg-indigo-600 text-white shadow-md flex items-center gap-2">
                Layanan & Kebijakan
            </button>
            <button onclick="switchMainTab('berita')" id="btn-main-berita" class="px-8 py-3 rounded-xl font-extrabold text-sm transition text-slate-500 hover:bg-slate-100 flex items-center gap-2">
                Portal Berita
            </button>
            <button onclick="switchMainTab('profil')" id="btn-main-profil" class="px-8 py-3 rounded-xl font-extrabold text-sm transition text-slate-500 hover:bg-slate-100 flex items-center gap-2">
                Profil Saya
            </button>
        </div>

        <!-- SECTION 1: LAYANAN -->
        <div id="section-layanan" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200/60 p-8">
                    <h2 class="text-2xl font-extrabold text-slate-800 mb-6 italic">Arsip Kebijakan Publik</h2>
                    
                    <div class="flex flex-wrap gap-2 mb-8 bg-slate-50 p-1.5 rounded-2xl w-fit border border-slate-100">
                        <button onclick="switchTabKebijakan('MoU/PKS')" id="btn-mou" class="tab-btn px-6 py-2.5 rounded-xl font-bold text-sm transition bg-indigo-600 text-white shadow-md">MoU / PKS</button>
                        <button onclick="switchTabKebijakan('TIK Kemlu')" id="btn-tik-kemlu" class="tab-btn px-6 py-2.5 rounded-xl font-bold text-sm transition text-slate-500 hover:bg-slate-200/50">TIK Kemlu</button>
                        <button onclick="switchTabKebijakan('TIK Non-Kemlu')" id="btn-tik-non" class="tab-btn px-6 py-2.5 rounded-xl font-bold text-sm transition text-slate-500 hover:bg-slate-200/50">TIK Non-Kemlu</button>
                    </div>

                    <div class="bg-slate-50 rounded-3xl p-6 mb-8 border border-slate-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="lg:col-span-3">
                                <div class="relative">
                                    <input type="text" id="searchInput" onkeyup="applyFilters()" placeholder="Ketik kata kunci judul..." class="w-full bg-white border border-slate-200 rounded-2xl py-3 pl-12 pr-4 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition">
                                </div>
                            </div>
                            <div class="filter-group-mou hidden">
                                <select id="filter-satker" onchange="applyFilters()" class="w-full bg-white border border-slate-200 rounded-xl py-2.5 px-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-blue-500 outline-none">
                                    <option value="">Semua Satker</option>
                                    @foreach($allKebijakan->where('tipe_dokumen', 'MoU/PKS')->pluck('satker_kemlu')->unique() as $s) <option value="{{ $s }}">{{ $s }}</option> @endforeach
                                </select>
                            </div>
                            <div class="filter-group-mou hidden">
                                <select id="filter-external" onchange="applyFilters()" class="w-full bg-white border border-slate-200 rounded-xl py-2.5 px-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-blue-500 outline-none">
                                    <option value="">Semua External</option>
                                    @foreach($allKebijakan->where('tipe_dokumen', 'MoU/PKS')->pluck('instansi_external')->unique() as $ext) <option value="{{ $ext }}">{{ $ext }}</option> @endforeach
                                </select>
                            </div>
                            <div class="filter-group-non hidden lg:col-span-2">
                                <select id="filter-instansi" onchange="applyFilters()" class="w-full bg-white border border-slate-200 rounded-xl py-2.5 px-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-blue-500 outline-none">
                                    <option value="">Semua Instansi</option>
                                    @foreach($allKebijakan->where('tipe_dokumen', 'TIK Non-Kemlu')->pluck('instansi')->unique() as $inst) <option value="{{ $inst }}">{{ $inst }}</option> @endforeach
                                </select>
                            </div>
                            <div class="lg:col-span-1"><input type="number" id="year-start" onkeyup="applyFilters()" onchange="applyFilters()" placeholder="Thn Awal" class="w-full bg-white border border-slate-200 rounded-xl py-2.5 px-4 text-sm focus:ring-2 focus:ring-blue-500 outline-none"></div>
                            <div class="lg:col-span-1"><input type="number" id="year-end" onkeyup="applyFilters()" onchange="applyFilters()" placeholder="Thn Akhir" class="w-full bg-white border border-slate-200 rounded-xl py-2.5 px-4 text-sm focus:ring-2 focus:ring-blue-500 outline-none"></div>
                        </div>
                    </div>

                    <div id="kebijakanContainer" class="space-y-4">
                        @forelse($allKebijakan ?? [] as $kebijakan)
                            @php
                                $tahunStart = $kebijakan->tipe_dokumen === 'MoU/PKS' ? ($kebijakan->tanggal_disahkan ? \Carbon\Carbon::parse($kebijakan->tanggal_disahkan)->year : null) : $kebijakan->tahun;
                                $tahunEnd = $kebijakan->tipe_dokumen === 'MoU/PKS' ? ($kebijakan->tanggal_berakhir ? \Carbon\Carbon::parse($kebijakan->tanggal_berakhir)->year : null) : $kebijakan->tahun;
                            @endphp
                            <div class="kebijakan-item group bg-white border border-slate-100 rounded-3xl p-6 flex items-start gap-5 hover:shadow-md" data-category="{{ $kebijakan->tipe_dokumen }}" data-satker="{{ $kebijakan->satker_kemlu ?? '' }}" data-external="{{ $kebijakan->instansi_external ?? '' }}" data-instansi="{{ $kebijakan->instansi ?? '' }}" data-year-start="{{ $tahunStart }}" data-year-end="{{ $tahunEnd }}" data-search="{{ strtolower($kebijakan->judul) }}">
                                <div class="bg-indigo-50 text-indigo-600 p-4 rounded-2xl group-hover:bg-indigo-600 group-hover:text-white transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-slate-800 text-lg mb-1 group-hover:text-indigo-700 transition">{{ $kebijakan->judul }}</h4>
                                    
                                    <!-- PENAMBAHAN INFO VIEWS DI SINI -->
                                    <div class="flex flex-wrap items-center gap-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                        @if($kebijakan->tipe_dokumen === 'MoU/PKS') <span>{{ $kebijakan->satker_kemlu }}</span> <span class="text-slate-200">↔</span> <span>{{ $kebijakan->instansi_external }}</span>
                                        @else <span>{{ $kebijakan->satker_kemlu ?? $kebijakan->instansi ?? 'Kementerian Luar Negeri' }}</span> @endif
                                        <span class="text-slate-200">•</span><span>THN: {{ $tahunStart }}</span>
                                        <span class="text-slate-200">•</span>
                                        <span class="flex items-center gap-1 text-indigo-500">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            {{ $kebijakan->views ?? 0 }} Dilihat
                                        </span>
                                    </div>
                                    <!-- AKHIR PENAMBAHAN INFO VIEWS -->

                                    <div id="dtl-judul-{{ $loop->index }}" class="hidden">{{ $kebijakan->judul }}</div><div id="dtl-ket-{{ $loop->index }}" class="hidden">{{ $kebijakan->keterangan ?? 'Tidak ada keterangan tambahan.' }}</div><div id="dtl-link-{{ $loop->index }}" class="hidden">{{ $kebijakan->tautan ?? '' }}</div>
                                </div>
                                <button onclick="catatView('{{ $kebijakan->id }}', '{{ $kebijakan->tipe_dokumen }}'); openPolicyModal('{{ $loop->index }}')" class="self-center bg-slate-100 hover:bg-slate-800 hover:text-white text-slate-600 px-6 py-2.5 rounded-xl text-[10px] font-extrabold uppercase">Detail</button>
                            </div>
                        @empty <div class="py-12 text-center text-slate-400 italic">Data belum tersedia.</div> @endforelse
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200/60 p-8 sticky top-8">
                    <h3 class="text-xl font-extrabold text-slate-800 mb-8 flex items-center gap-3">Riwayat Janji Temu</h3>
                    <div class="space-y-6 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                        @forelse($appointments ?? [] as $appt)
                            <div class="relative pl-6 border-l-4 {{ $appt->status == 'approved' ? 'border-emerald-500' : ($appt->status == 'rejected' ? 'border-red-500' : 'border-amber-400') }} py-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="text-[10px] font-extrabold text-slate-400">{{ \Carbon\Carbon::parse($appt->preferensi_waktu ?? $appt->created_at)->format('d M Y') }}</span>
                                        <span class="px-2 py-0.5 rounded-[6px] text-[9px] font-bold uppercase {{ $appt->status == 'approved' ? 'bg-emerald-100 text-emerald-700' : ($appt->status == 'rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">{{ $appt->status }}</span>
                                    </div>
                                    <h5 class="font-bold text-slate-800 text-sm">{{ $appt->tujuan }}</h5>
                                    <p class="text-[9px] text-slate-500 mt-1 italic">"{{ Str::limit($appt->detail_tujuan, 50) }}"</p>
                                    @if($appt->status == 'approved' && $appt->tanggal_waktu_pertemuan)
                                        <div class="mt-2 bg-emerald-50 rounded-lg p-2 border border-emerald-100"><span class="block text-[9px] font-extrabold text-emerald-600 uppercase">Jadwal Fix Admin:</span><p class="text-[10px] font-extrabold text-emerald-700">{{ \Carbon\Carbon::parse($appt->tanggal_waktu_pertemuan)->format('d M Y, H:i') }} WIB</p></div>
                                    @endif
                                </div>

                                <div class="mt-3 flex justify-end">
                                    <div id="data-user-{{ $appt->id }}" class="hidden"
                                        data-instansi="{{ $appt->instansi }}" data-tujuan="{{ $appt->tujuan }}" data-detail="{{ $appt->detail_tujuan }}" data-alamat="{{ $appt->alamat }}"
                                        data-waktu-pref="{{ $appt->preferensi_waktu ? \Carbon\Carbon::parse($appt->preferensi_waktu)->format('d M Y, H:i') : 'Tidak ada' }}"
                                        data-status="{{ $appt->status }}"
                                        data-waktu-fix="{{ $appt->tanggal_waktu_pertemuan ? \Carbon\Carbon::parse($appt->tanggal_waktu_pertemuan)->format('d M Y, H:i') : '-' }}"
                                        data-link-meeting="{{ $appt->link_meeting }}" data-alamat-fix="{{ $appt->alamat_pertemuan }}" data-maps="{{ $appt->link_maps }}"
                                        data-catatan="{{ $appt->keterangan_tambahan }}" data-alasan="{{ $appt->alasan_penolakan }}" data-mode="{{ $appt->mode ?? 'Luring' }}"
                                    ></div>
                                    <button onclick="openUserDetail('{{ $appt->id }}')" class="bg-indigo-50 text-indigo-600 px-4 py-1.5 rounded-lg text-xs font-bold hover:bg-indigo-600 hover:text-white transition shadow-sm border border-indigo-100">
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                        @empty <div class="py-8 text-center text-slate-400 italic text-sm">Belum ada riwayat.</div> @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: BERITA -->
        <div id="section-berita" class="hidden">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 mb-8 flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="flex flex-wrap gap-2 w-full md:w-auto">
                    <button onclick="filterBerita('Semua')" id="flt-semua" class="flt-btn px-5 py-2 rounded-xl font-bold text-xs bg-slate-800 text-white transition">Semua Kategori</button>
                    <button onclick="filterBerita('Dalam Negeri')" id="flt-dalam" class="flt-btn px-5 py-2 rounded-xl font-bold text-xs text-slate-500 hover:bg-slate-100 transition">Dalam Negeri</button>
                    <button onclick="filterBerita('Mancanegara')" id="flt-luar" class="flt-btn px-5 py-2 rounded-xl font-bold text-xs text-slate-500 hover:bg-slate-100 transition">Mancanegara</button>
                    <button onclick="filterBerita('Kerjasama')" id="flt-kerja" class="flt-btn px-5 py-2 rounded-xl font-bold text-xs text-slate-500 hover:bg-slate-100 transition">Kerjasama</button>
                </div>
                <div class="relative w-full md:w-72">
                    <input type="text" id="searchBerita" onkeyup="applyFilterBerita()" placeholder="Cari berita terkini..." class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-10 pr-4 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="gridBerita">
                @forelse($beritaList ?? [] as $berita)
                    <div class="berita-card bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl transition duration-300 flex flex-col" data-kategori="{{ $berita->kategori }}" data-judul="{{ strtolower($berita->judul) }}">
                        <div class="h-52 w-full relative bg-slate-200 overflow-hidden">
                            @if($berita->foto) <img src="{{ asset('storage/' . $berita->foto) }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                            @else <div class="w-full h-full flex items-center justify-center text-slate-400">Gambar</div> @endif
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg text-[10px] font-extrabold text-blue-700 uppercase tracking-widest shadow-sm">{{ $berita->kategori }}</div>
                        </div>

                        <div class="p-6 flex flex-col flex-1">
                            
                            <!-- PENAMBAHAN INFO VIEWS DI SINI -->
                            <div class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">
                                <span>{{ \Carbon\Carbon::parse($berita->tanggal)->format('d M Y') }}</span>
                                <span class="text-slate-200">•</span>
                                <span>{{ $berita->lokasi }}</span>
                                <span class="text-slate-200">•</span>
                                <span class="flex items-center gap-1 text-blue-500">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    {{ $berita->views ?? 0 }} Dilihat
                                </span>
                            </div>
                            <!-- AKHIR PENAMBAHAN INFO VIEWS -->

                            <h3 class="text-lg font-extrabold text-slate-800 leading-snug mb-3 hover:text-blue-600 transition">{{ $berita->judul }}</h3>
                            <p class="text-sm text-slate-500 line-clamp-3 leading-relaxed mb-6 flex-1">{{ $berita->lead }}</p>
                            
                            <div class="hidden" id="brt-foto-{{ $berita->id }}">{{ $berita->foto ? asset('storage/' . $berita->foto) : '' }}</div>
                            <div class="hidden" id="brt-kat-{{ $berita->id }}">{{ $berita->kategori }}</div>
                            <div class="hidden" id="brt-judul-{{ $berita->id }}">{{ $berita->judul }}</div>
                            <div class="hidden" id="brt-info-{{ $berita->id }}">{{ \Carbon\Carbon::parse($berita->tanggal)->format('d F Y') }} • {{ $berita->lokasi }}</div>
                            <div class="hidden" id="brt-lead-{{ $berita->id }}">{{ $berita->lead }}</div>
                            <div class="hidden" id="brt-body-{{ $berita->id }}">{{ $berita->body }}</div>
                            <div class="hidden" id="brt-closing-{{ $berita->id }}">{{ $berita->closing }}</div>

                            <button onclick="catatView('{{ $berita->id }}', 'Berita'); openModalBerita('{{ $berita->id }}')" class="w-full bg-slate-50 hover:bg-blue-600 hover:text-white text-blue-600 font-bold py-3 rounded-xl transition text-xs uppercase tracking-widest">Baca Selengkapnya</button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 py-20 text-center bg-white rounded-3xl border border-slate-200"><h3 class="text-xl font-bold text-slate-500 mb-1">Belum Ada Berita</h3></div>
                @endforelse
            </div>
        </div>

        <!-- SECTION 3: PROFIL SAYA -->
        <div id="section-profil" class="hidden">
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200/60 p-8 max-w-3xl mx-auto lg:mx-0">
                <h3 class="text-2xl font-extrabold text-slate-800 mb-6 italic">Identitas Akun</h3>
                
                <!-- IDENTITAS READONLY -->
                <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50 p-6 rounded-3xl border border-slate-100">
                    <div><span class="block text-[10px] font-bold text-slate-400 uppercase">Nama Terdaftar</span><span class="font-extrabold text-slate-800">{{ auth()->user()->name }}</span></div>
                    <div><span class="block text-[10px] font-bold text-slate-400 uppercase">Email Terdaftar</span><span class="font-extrabold text-slate-800">{{ auth()->user()->email }}</span></div>
                    <div class="md:col-span-2"><span class="block text-[10px] font-bold text-slate-400 uppercase">Hak Akses</span><span class="font-extrabold text-blue-600 uppercase">{{ auth()->user()->role }}</span></div>
                </div>

                <!-- LENGKAPI PROFIL -->
                <h3 class="text-2xl font-extrabold text-slate-800 mb-6 italic border-t pt-8">Lengkapi Profil Anda</h3>
                <form action="{{ route('profile.custom.update_detail') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none"></div>
                        
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nomor Telepon</label>
                        <input type="text" name="no_telp" value="{{ auth()->user()->no_telp }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="0812345..."></div>
                        
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ auth()->user()->tanggal_lahir }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none"></div>
                        
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Status Pekerjaan</label>
                        <input type="text" name="pekerjaan" value="{{ auth()->user()->pekerjaan }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Karyawan Swasta / PNS / Mahasiswa"></div>
                        
                        <div class="md:col-span-2"><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Alamat Rumah</label>
                        <textarea name="alamat" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">{{ auth()->user()->alamat }}</textarea></div>
                    </div>
                    <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 px-6 rounded-xl transition mt-2 shadow-md w-full md:w-auto">Simpan Profil</button>
                </form>

                <!-- GANTI PASSWORD -->
                <h3 class="text-2xl font-extrabold text-slate-800 mb-6 italic border-t pt-8 mt-8">Ganti Kata Sandi</h3>
                <form action="{{ route('password.custom.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Password Lama</label><input type="password" name="current_password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">@error('current_password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Password Baru</label><input type="password" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Min. 8 Karakter">@error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror</div>
                        <div><label class="block text-xs font-bold text-slate-500 uppercase mb-1">Konfirmasi Password Baru</label><input type="password" name="password_confirmation" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none"></div>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition mt-4 shadow-md w-full md:w-auto">Simpan Password Baru</button>
                </form>
            </div>
        </div>

    </div>

    <!-- MODAL POPUP BAWAAN START -->
    <div id="modalBeritaUtama" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm hidden items-center justify-center z-50 p-4 lg:p-10">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-4xl overflow-hidden flex flex-col max-h-full">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center shrink-0">
                <span id="mdl-brt-kategori" class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-xs font-extrabold uppercase tracking-widest"></span>
                <button onclick="closeModalBerita()" class="text-slate-400 hover:text-red-500 bg-slate-100 hover:bg-red-50 p-2 rounded-full transition">X</button>
            </div>
            <div class="p-8 md:p-10 overflow-y-auto custom-scrollbar flex-1 bg-white">
                <h1 id="mdl-brt-judul" class="text-3xl md:text-4xl font-black text-slate-900 mb-4 leading-tight"></h1>
                <p id="mdl-brt-info" class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8"></p>
                <img id="mdl-brt-foto" src="" class="w-full h-64 md:h-[400px] object-cover rounded-3xl mb-10 bg-slate-100 shadow-inner">
                <div class="max-w-3xl mx-auto">
                    <p id="mdl-brt-lead" class="text-lg md:text-xl font-medium text-slate-800 mb-8 leading-relaxed"></p>
                    <div id="mdl-brt-body" class="text-base text-slate-600 leading-loose space-y-6 mb-8 whitespace-pre-line"></div>
                    <div id="mdl-brt-closing" class="text-base font-medium text-slate-700 italic border-l-4 border-slate-300 pl-6 py-2"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="policyModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg p-8">
            <div class="flex justify-between items-start mb-6"><div class="bg-indigo-100 text-indigo-600 p-3 rounded-2xl">Dokumen</div><button onclick="closePolicyModal()" class="text-slate-400 hover:text-slate-600 p-2">X</button></div>
            <h3 id="modal-judul" class="text-xl font-extrabold text-slate-800 mb-4 leading-tight"></h3>
            <div class="bg-slate-50 rounded-2xl p-6 mb-6 border border-slate-100"><p id="modal-ket" class="text-sm text-slate-600 leading-relaxed"></p></div>
            <div id="modal-link-container" class="hidden"><a id="modal-link" href="#" target="_blank" class="w-full bg-blue-600 text-white font-bold py-3.5 px-4 rounded-2xl transition flex justify-center items-center gap-2">Buka Tautan</a></div>
        </div>
    </div>

    <div id="userDetailModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div id="modalHeaderColor" class="p-6 flex justify-between items-center shrink-0 text-white">
                <div class="flex items-center gap-4"><div class="bg-white/20 p-3 rounded-2xl">Janji</div><div><h3 class="text-xl font-black">Detail Janji Temu</h3><p id="txt-status-badge" class="text-[10px] uppercase tracking-widest font-bold bg-white/20 px-2 py-0.5 rounded-md inline-block mt-1"></p></div></div>
                <button onclick="closeUserModal()" class="text-white/70 hover:text-white bg-white/10 p-2 rounded-full transition">X</button>
            </div>
            <div class="p-8 overflow-y-auto space-y-8 bg-slate-50/50 custom-scrollbar flex-1">
                <div id="adminResponseSection" class="hidden">
                    <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2"><span class="w-2 h-2 bg-indigo-500 rounded-full"></span> Hasil Konfirmasi Admin</h4>
                    <div class="bg-white border border-indigo-100 rounded-3xl p-6 shadow-sm space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><span class="block text-[10px] font-extrabold text-slate-400 uppercase mb-1">Jadwal Fix Pertemuan</span><span id="res-waktu" class="text-sm font-bold text-indigo-700"></span></div>
                            <div id="row-link" class="hidden"><span class="block text-[10px] font-extrabold text-slate-400 uppercase mb-1">Link Pertemuan (Daring)</span><a id="res-link" href="#" target="_blank" class="text-xs font-bold text-blue-600 underline break-all"></a></div>
                            <div id="row-alamat" class="hidden"><span class="block text-[10px] font-extrabold text-slate-400 uppercase mb-1">Lokasi Gedung / Ruangan</span><span id="res-alamat" class="text-sm font-bold text-slate-800"></span><a id="res-maps" href="#" target="_blank" class="flex items-center gap-1 text-[10px] text-emerald-600 font-bold mt-1 hover:underline">Lihat di Google Maps</a></div>
                        </div>
                        <div id="row-catatan" class="pt-3 border-t border-slate-50"><span class="block text-[10px] font-extrabold text-slate-400 uppercase mb-1">Catatan Tambahan Admin:</span><p id="res-catatan" class="text-sm text-slate-600 italic"></p></div>
                    </div>
                </div>
                <div id="rejectSection" class="hidden bg-red-50 border border-red-100 p-6 rounded-3xl"><span class="block text-[10px] font-extrabold text-red-400 uppercase mb-2">Alasan Penolakan:</span><p id="res-alasan" class="text-sm text-red-800 font-medium"></p></div>
                <div>
                    <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2"><span class="w-2 h-2 bg-slate-300 rounded-full"></span> Data Permohonan Anda</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4"><div class="bg-white p-4 rounded-2xl border border-slate-100"><span class="block text-[10px] font-extrabold text-slate-400 uppercase mb-1">Instansi</span><span id="usr-instansi" class="text-sm font-bold text-slate-800"></span></div><div class="bg-white p-4 rounded-2xl border border-slate-100"><span class="block text-[10px] font-extrabold text-slate-400 uppercase mb-1">Preferensi Waktu</span><span id="usr-waktu" class="text-sm font-bold text-slate-800"></span></div></div>
                    <div class="mt-4 bg-white p-4 rounded-2xl border border-slate-100"><span class="block text-[10px] font-extrabold text-slate-400 uppercase mb-1">Tujuan Pembahasan</span><p id="usr-tujuan" class="text-sm font-bold text-slate-800 mb-2"></p><div id="usr-detail" class="text-xs text-slate-500 bg-slate-50 p-4 rounded-xl shadow-inner whitespace-pre-wrap"></div></div>
                </div>
            </div>
            <div class="p-6 border-t bg-white flex justify-end"><button onclick="closeUserModal()" class="bg-slate-800 hover:bg-slate-900 text-white px-8 py-3 rounded-xl text-sm font-bold shadow-lg transition">Tutup Detail</button></div>
        </div>
    </div>
    <!-- MODAL POPUP BAWAAN END -->

    <script>
        // SCRIPT TAMBAHAN UNTUK MENCATAT VIEWS KE DATABASE
        function catatView(idDokumen, tipeDokumen) {
            fetch('{{ route("record.view") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    id: idDokumen,
                    tipe_dokumen: tipeDokumen
                })
            }).then(response => console.log('View tercatat!'))
              .catch(error => console.error('Gagal mencatat view', error));
        }

        // SCRIPT SWITCH TAB UTAMA UPDATE
        function switchMainTab(menu) {
            ['layanan', 'berita', 'profil'].forEach(m => {
                document.getElementById('section-' + m).classList.add('hidden');
                document.getElementById('btn-main-' + m).className = "px-8 py-3 rounded-xl font-extrabold text-sm transition text-slate-500 hover:bg-slate-100 flex items-center gap-2";
            });
            document.getElementById('section-' + menu).classList.remove('hidden');
            
            let colorClass = menu === 'layanan' ? 'bg-indigo-600' : 'bg-blue-600';
            document.getElementById('btn-main-' + menu).className = `px-8 py-3 rounded-xl font-extrabold text-sm transition ${colorClass} text-white shadow-md flex items-center gap-2`;
        }

        // Script Berita
        let currentKategoriBerita = 'Semua';
        function filterBerita(kategori) {
            currentKategoriBerita = kategori;
            const mapBtn = {'Semua': 'flt-semua', 'Dalam Negeri': 'flt-dalam', 'Mancanegara': 'flt-luar', 'Kerjasama': 'flt-kerja'};
            document.querySelectorAll('.flt-btn').forEach(btn => btn.className = "flt-btn px-5 py-2 rounded-xl font-bold text-xs text-slate-500 hover:bg-slate-100 transition");
            document.getElementById(mapBtn[kategori]).className = "flt-btn px-5 py-2 rounded-xl font-bold text-xs bg-slate-800 text-white transition";
            applyFilterBerita();
        }
        function applyFilterBerita() {
            let search = document.getElementById('searchBerita').value.toLowerCase();
            document.querySelectorAll('.berita-card').forEach(card => {
                let matchKat = (currentKategoriBerita === 'Semua' || card.dataset.kategori === currentKategoriBerita);
                let matchSearch = card.dataset.judul.includes(search);
                card.style.display = (matchKat && matchSearch) ? 'flex' : 'none';
            });
        }
        function openModalBerita(id) {
            let srcFoto = document.getElementById('brt-foto-'+id).innerText;
            let imgEl = document.getElementById('mdl-brt-foto');
            if(srcFoto) { imgEl.src = srcFoto; imgEl.style.display = 'block'; } else { imgEl.style.display = 'none'; }
            document.getElementById('mdl-brt-kategori').innerText = document.getElementById('brt-kat-'+id).innerText;
            document.getElementById('mdl-brt-judul').innerText = document.getElementById('brt-judul-'+id).innerText;
            document.getElementById('mdl-brt-info').innerText = document.getElementById('brt-info-'+id).innerText;
            document.getElementById('mdl-brt-lead').innerText = document.getElementById('brt-lead-'+id).innerText;
            document.getElementById('mdl-brt-body').innerText = document.getElementById('brt-body-'+id).innerText;
            let closing = document.getElementById('brt-closing-'+id).innerText;
            let closeEl = document.getElementById('mdl-brt-closing');
            if(closing.trim() !== "") { closeEl.innerText = closing; closeEl.style.display = 'block'; } else { closeEl.style.display = 'none'; }
            document.getElementById('modalBeritaUtama').classList.replace('hidden', 'flex');
            document.body.style.overflow = 'hidden';
        }
        function closeModalBerita() { document.getElementById('modalBeritaUtama').classList.replace('flex', 'hidden'); document.body.style.overflow = 'auto'; }

        // Script Kebijakan
        let currentTab = 'MoU/PKS';
        function switchTabKebijakan(type) {
            currentTab = type;
            const btnMap = {'MoU/PKS': 'btn-mou', 'TIK Kemlu': 'btn-tik-kemlu', 'TIK Non-Kemlu': 'btn-tik-non'};
            document.querySelectorAll('.tab-btn').forEach(btn => btn.className = "tab-btn px-6 py-2.5 rounded-xl font-bold text-sm transition text-slate-500 hover:bg-slate-200/50");
            document.getElementById(btnMap[type]).className = "tab-btn px-6 py-2.5 rounded-xl font-bold text-sm transition bg-indigo-600 text-white shadow-md";
            document.querySelectorAll('.filter-group-mou, .filter-group-non').forEach(el => el.classList.add('hidden'));
            if(type === 'MoU/PKS') document.querySelectorAll('.filter-group-mou').forEach(el => el.classList.remove('hidden'));
            if(type === 'TIK Non-Kemlu') document.querySelectorAll('.filter-group-non').forEach(el => el.classList.remove('hidden'));
            applyFilters();
        }
        function applyFilters() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const satker = document.getElementById('filter-satker').value;
            const external = document.getElementById('filter-external').value;
            const instansi = document.getElementById('filter-instansi').value;
            const yearStart = parseInt(document.getElementById('year-start').value) || 0;
            const yearEnd = parseInt(document.getElementById('year-end').value) || 9999;
            document.querySelectorAll('.kebijakan-item').forEach(item => {
                const ds = item.dataset;
                const matchTab = (ds.category === currentTab);
                const matchSearch = ds.search.includes(search);
                const itemYearStart = parseInt(ds.yearStart) || 0;
                const itemYearEnd = parseInt(ds.yearEnd) || itemYearStart;
                const matchYear = (itemYearStart >= yearStart && itemYearStart <= yearEnd) || (itemYearEnd >= yearStart && itemYearEnd <= yearEnd);
                let matchSpecific = true;
                if(currentTab === 'MoU/PKS') { matchSpecific = (satker === "" || ds.satker === satker) && (external === "" || ds.external === external); } 
                else if(currentTab === 'TIK Non-Kemlu') { matchSpecific = (instansi === "" || ds.instansi === instansi); }
                item.style.display = (matchTab && matchSearch && matchYear && matchSpecific) ? 'flex' : 'none';
            });
        }
        function openPolicyModal(index) {
            document.getElementById('modal-judul').innerText = document.getElementById('dtl-judul-'+index).innerText;
            document.getElementById('modal-ket').innerText = document.getElementById('dtl-ket-'+index).innerText;
            const link = document.getElementById('dtl-link-'+index).innerText;
            const linkBtn = document.getElementById('modal-link-container');
            if(link.trim() !== "") { linkBtn.classList.remove('hidden'); document.getElementById('modal-link').href = link;
            } else { linkBtn.classList.add('hidden'); }
            document.getElementById('policyModal').classList.replace('hidden', 'flex');
        }
        function closePolicyModal() { document.getElementById('policyModal').classList.replace('flex', 'hidden'); }

        // Script User Detail
        function openUserDetail(id) {
            const data = document.getElementById('data-user-' + id).dataset;
            const modal = document.getElementById('userDetailModal');
            const header = document.getElementById('modalHeaderColor');
            document.getElementById('usr-instansi').innerText = data.instansi;
            document.getElementById('usr-waktu').innerText = data.waktuPref;
            document.getElementById('usr-tujuan').innerText = data.tujuan;
            document.getElementById('usr-detail').innerText = data.detail;
            document.getElementById('txt-status-badge').innerText = data.status;
            const adminSec = document.getElementById('adminResponseSection');
            const rejectSec = document.getElementById('rejectSection');
            adminSec.classList.add('hidden'); rejectSec.classList.add('hidden');
            header.className = 'p-6 flex justify-between items-center shrink-0 text-white ';
            if (data.status === 'approved') {
                header.classList.add('bg-gradient-to-r', 'from-emerald-500', 'to-teal-600');
                adminSec.classList.remove('hidden');
                document.getElementById('res-waktu').innerText = data.waktuFix;
                document.getElementById('res-catatan').innerText = data.catatan || '-';
                if (data.mode && data.mode.toLowerCase() === 'daring') {
                    document.getElementById('row-link').classList.remove('hidden');
                    document.getElementById('row-alamat').classList.add('hidden');
                    document.getElementById('res-link').href = data.linkMeeting || '#';
                    document.getElementById('res-link').innerText = data.linkMeeting || 'Link tidak tersedia';
                } else {
                    document.getElementById('row-link').classList.add('hidden');
                    document.getElementById('row-alamat').classList.remove('hidden');
                    document.getElementById('res-alamat').innerText = data.alamatFix || 'Menunggu konfirmasi ruangan';
                    const mapsEl = document.getElementById('res-maps');
                    if(data.maps && data.maps.trim() !== '') { mapsEl.href = data.maps; mapsEl.classList.remove('hidden'); } else { mapsEl.classList.add('hidden'); }
                }
            } else if (data.status === 'rejected') {
                header.classList.add('bg-gradient-to-r', 'from-red-500', 'to-rose-600');
                rejectSec.classList.remove('hidden');
                document.getElementById('res-alasan').innerText = data.alasan || 'Tidak ada alasan spesifik.';
            } else { header.classList.add('bg-gradient-to-r', 'from-amber-400', 'to-orange-500'); }
            modal.classList.replace('hidden', 'flex');
        }
        function closeUserModal() { document.getElementById('userDetailModal').classList.replace('flex', 'hidden'); }
        document.addEventListener('DOMContentLoaded', () => switchTabKebijakan('MoU/PKS'));
    </script>
</body>
</html>