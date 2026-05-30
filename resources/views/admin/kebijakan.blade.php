<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Kebijakan & Dokumen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 min-h-screen flex">

    <!-- Sidebar Navigation -->
    <aside class="w-72 bg-slate-900 text-slate-300 flex flex-col shadow-2xl z-20 hidden md:flex">
        <div class="p-6 border-b border-slate-800 flex items-center gap-3">
            <div class="bg-blue-500 text-white p-2 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <h1 class="text-white font-bold text-lg leading-tight">Panel Admin</h1>
                <p class="text-xs text-slate-500">{{ ucfirst(explode('@', $user->email)[0]) }}</p>
            </div>
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('admin.appointment') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition text-sm font-medium">Kelola Appointment</a>
            <a href="{{ route('admin.kebijakan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/50 font-bold">Kelola Kebijakan & Dokumen</a>
        </nav>
        <div class="p-4 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="flex justify-center items-center gap-2 w-full bg-slate-800 hover:bg-red-500/20 hover:text-red-400 py-3 rounded-xl text-sm font-bold transition">Logout</button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <!-- Header -->
        <header class="bg-white px-8 py-5 border-b border-slate-200 shadow-sm flex justify-between items-center z-10">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-800">Manajemen Dokumen & Kebijakan</h2>
                <p class="text-sm text-slate-500 mt-1">Input draf kebijakan TIK atau dokumen kerja sama ke dalam sistem.</p>
            </div>
        </header>

        <!-- Scrollable Content -->
        <div class="flex-1 p-8 overflow-y-auto bg-slate-50 grid grid-cols-1 xl:grid-cols-2 gap-8 items-start">
            
            <!-- Left Column: Input Forms with Tabs -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
                <!-- Tab Headers -->
                <div class="flex border-b border-slate-200 bg-slate-50 text-sm font-bold">
                    <button onclick="switchTab('tab-mou')" id="btn-mou" class="flex-1 py-4 text-indigo-700 border-b-2 border-indigo-600 bg-white transition">MoU / PKS</button>
                    <button onclick="switchTab('tab-tik')" id="btn-tik" class="flex-1 py-4 text-slate-500 hover:text-slate-800 transition">TIK Kemlu</button>
                    <button onclick="switchTab('tab-non')" id="btn-non" class="flex-1 py-4 text-slate-500 hover:text-slate-800 transition">TIK Non-Kemlu</button>
                </div>

                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-4 bg-emerald-50 text-emerald-700 px-4 py-3 rounded-xl text-sm font-bold">{{ session('success') }}</div>
                    @endif

                    <!-- Form MoU / PKS -->
                    <form id="tab-mou" action="{{ route('admin.mou.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Jenis</label>
                                <select name="jenis" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"><option value="MoU">MoU</option><option value="PKS">PKS</option></select></div>
                            <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Status</label>
                                <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"><option value="pending">Dalam Proses</option><option value="aktif">Aktif</option><option value="tidak aktif">Tidak Aktif</option></select></div>
                        </div>
                        <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Perihal Dokumen</label>
                            <input type="text" name="perihal" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Satker Kemlu</label>
                                <input type="text" name="satker_kemlu" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">K/L/I External</label>
                                <input type="text" name="instansi_external" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Tgl Disahkan</label>
                                <input type="date" name="tanggal_disahkan" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Tgl Berakhir</label>
                                <input type="date" name="tanggal_berakhir" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                        </div>
                        <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Keterangan</label>
                            <textarea name="keterangan" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm resize-none"></textarea></div>
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl transition">Simpan MoU/PKS</button>
                    </form>

                    <!-- Form TIK Kemlu -->
                    <form id="tab-tik" action="{{ route('admin.tik_kemlu.store') }}" method="POST" class="space-y-4 hidden">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Jenis Kebijakan</label>
                                <input type="text" name="jenis_kebijakan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nomor Kebijakan</label>
                                <input type="text" name="nomor_kebijakan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                        </div>
                        <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Tahun Penerbitan</label>
                            <input type="number" name="tahun" min="1900" max="9999" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm" placeholder="Contoh: 2024"></div>
                        <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Perihal Kebijakan</label>
                            <input type="text" name="perihal" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                        <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Tautan (Link)</label>
                            <input type="url" name="tautan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm" placeholder="https://..."></div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition">Simpan TIK Kemlu</button>
                    </form>

                    <!-- Form TIK Non-Kemlu -->
                    <form id="tab-non" action="{{ route('admin.tik_non_kemlu.store') }}" method="POST" class="space-y-4 hidden">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Jenis Kebijakan</label>
                                <input type="text" name="jenis_kebijakan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                            <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nomor Kebijakan</label>
                                <input type="text" name="nomor_kebijakan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                        </div>
                        <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Instansi</label>
                            <input type="text" name="instansi" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                        <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Tahun Penerbitan</label>
                            <input type="number" name="tahun" min="1900" max="9999" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                        <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Perihal Kebijakan</label>
                            <input type="text" name="perihal" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm"></div>
                        <div><label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Tautan (Link)</label>
                            <input type="url" name="tautan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm" placeholder="https://..."></div>
                        <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-4 rounded-xl transition">Simpan TIK Non-Kemlu</button>
                    </form>
                </div>
            </div>

            <!-- Right Column: Status Timeline -->
            <div class="space-y-4 h-[750px] flex flex-col">
                <h3 class="text-lg font-bold text-slate-800">Riwayat Pengajuan & Status</h3>
                <div class="flex-1 overflow-y-auto space-y-4 pr-2">
                    @forelse($allKebijakan as $item)
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 relative overflow-hidden">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <span class="bg-slate-100 text-slate-700 px-2 py-1 rounded text-[10px] font-extrabold uppercase tracking-widest border border-slate-200">{{ $item->tipe_dokumen }}</span>
                                    <span class="text-[11px] text-slate-400 font-bold ml-2">{{ $item->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                
                                @if($item->status == 'pending' || $item->status == 'dalam proses')
                                    <span class="bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-widest">Menunggu</span>
                                @elseif($item->status == 'approved' || $item->status == 'aktif')
                                    <span class="bg-emerald-100 text-emerald-700 px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-widest">Disetujui</span>
                                @elseif($item->status == 'rejected' || $item->status == 'tidak aktif')
                                    <span class="bg-red-100 text-red-700 px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-widest">Ditolak</span>
                                @endif
                            </div>
                            
                            <h4 class="font-bold text-slate-800 text-base leading-tight">{{ $item->judul }}</h4>
                            @if(isset($item->nomor_kebijakan)) <p class="text-xs text-slate-500 mt-1 font-mono">No: {{ $item->nomor_kebijakan }}</p> @endif

                            @if(($item->status == 'approved' || $item->status == 'aktif') && $item->keterangan_tambahan)
                                <div class="bg-emerald-50/50 border border-emerald-100 p-3 rounded-xl text-sm text-emerald-800 mt-3">
                                    <span class="font-bold block text-[10px] uppercase tracking-wider mb-0.5 text-emerald-600">Catatan Persetujuan:</span>
                                    {{ $item->keterangan_tambahan }}
                                </div>
                            @elseif(($item->status == 'rejected' || $item->status == 'tidak aktif') && $item->alasan_penolakan)
                                <div class="bg-red-50/50 border border-red-100 p-3 rounded-xl text-sm text-red-800 mt-3">
                                    <span class="font-bold block text-[10px] uppercase tracking-wider mb-0.5 text-red-600">Alasan Penolakan:</span>
                                    {{ $item->alasan_penolakan }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-500 font-medium">Belum ada dokumen yang diinput.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </main>

    <!-- Tab Switching Script -->
    <script>
        function switchTab(tabId) {
            // Sembunyikan semua form
            document.getElementById('tab-mou').classList.add('hidden');
            document.getElementById('tab-tik').classList.add('hidden');
            document.getElementById('tab-non').classList.add('hidden');
            
            // Reset gaya tombol
            ['btn-mou', 'btn-tik', 'btn-non'].forEach(id => {
                document.getElementById(id).className = 'flex-1 py-4 text-slate-500 hover:text-slate-800 transition';
            });

            // Tampilkan form yang dipilih & styling tombolnya
            document.getElementById(tabId).classList.remove('hidden');
            let activeBtn = document.getElementById(tabId.replace('tab', 'btn'));
            activeBtn.className = 'flex-1 py-4 text-indigo-700 border-b-2 border-indigo-600 bg-white font-bold transition';
        }
    </script>
</body>
</html>