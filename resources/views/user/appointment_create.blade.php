<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Janji Temu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google reCAPTCHA Script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 min-h-screen flex flex-col">

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200 p-4">
        <div class="max-w-3xl mx-auto flex justify-between items-center">
            <div class="font-extrabold text-xl text-indigo-700">PortalLayanan</div>
            <a href="{{ route('user.dashboard') }}" class="text-slate-500 hover:text-indigo-600 font-bold text-sm">Kembali ke Dashboard</a>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-4 w-full py-10 flex-1">
        <div class="bg-white rounded-3xl shadow-lg shadow-slate-200/50 border border-slate-100 p-8">
            <h1 class="text-2xl font-extrabold text-slate-800 mb-2">Ajukan Janji Temu Baru</h1>
            <p class="text-slate-500 text-sm mb-8">Silakan isi detail instansi dan tujuan pertemuan Anda.</p>

            <form action="{{ route('appointment.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Instansi Asal</label>
                        <input name="instansi" type="text" required class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 p-3" placeholder="Contoh: PT Sinar Jaya">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tujuan Utama</label>
                        <select name="tujuan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 p-3">
                            <option value="Penandatanganan Dokumen">Penandatanganan Dokumen</option>
                            <option value="Konsultasi TIK">Konsultasi TIK</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Instansi</label>
                    <input name="alamat" type="text" required class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 p-3" placeholder="Alamat lengkap instansi Anda">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Detail Tujuan Pembahasan</label>
                    <textarea name="detail_tujuan" required rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 p-3 resize-none" placeholder="Jelaskan secara singkat apa yang ingin dibahas..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Metode Pertemuan</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="mode" value="luring" required class="text-indigo-600"> Luring (Tatap Muka)</label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="radio" name="mode" value="daring" required class="text-indigo-600"> Daring (Online)</label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Preferensi Waktu (Opsional)</label>
                        <input name="preferensi_waktu" type="datetime-local" class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 p-3 text-sm">
                    </div>
                </div>

                <!-- Bagian reCAPTCHA -->
                <div class="py-4">
                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    @error('g-recaptcha-response')
                        <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end gap-4">
                    <a href="{{ route('user.dashboard') }}" class="text-slate-500 hover:text-slate-700 font-bold py-3 px-6 rounded-xl">Batal</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition">Ajukan Appointment</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>