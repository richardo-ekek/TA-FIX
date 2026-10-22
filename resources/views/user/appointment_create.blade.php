<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Janji Temu | Portal Terpadu Kemlu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>body{font-family:'Plus Jakarta Sans',sans-serif}@media(max-width:374px){.captcha-scale{transform:scale(.88);transform-origin:left top;width:267px;height:69px}}</style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">
    <nav class="sticky top-0 z-50 border-b border-slate-200 bg-white/90 backdrop-blur">
        <div class="mx-auto flex min-h-16 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('user.dashboard') }}" class="min-w-0 font-extrabold tracking-tight text-indigo-700">Portal Terpadu Kemlu</a>
            <a href="{{ route('user.dashboard') }}" class="shrink-0 rounded-xl px-3 py-2 text-sm font-bold text-slate-600 transition hover:bg-slate-100 hover:text-indigo-700"><span aria-hidden="true">←</span> <span class="hidden sm:inline">Kembali ke Dashboard</span><span class="sm:hidden">Kembali</span></a>
        </div>
    </nav>

    <main class="mx-auto w-full max-w-6xl px-4 py-7 sm:px-6 sm:py-10 lg:px-8">
        <header class="mb-6 overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-700 via-indigo-600 to-blue-600 px-6 py-7 text-white shadow-xl shadow-indigo-900/15 sm:px-9 sm:py-9">
            <p class="mb-3 text-xs font-bold uppercase tracking-[.18em] text-indigo-100">Layanan Pengajuan</p>
            <h1 class="text-2xl font-extrabold tracking-tight sm:text-3xl">Ajukan Janji Temu</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-indigo-100 sm:text-base">Lengkapi data berikut untuk mengajukan konsultasi atau pertemuan dengan tim terkait.</p>
        </header>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700" role="alert"><p class="font-extrabold">Pengajuan belum dapat dikirim.</p><p class="mt-1">Periksa kembali kolom yang ditandai dan lengkapi verifikasi reCAPTCHA.</p></div>
        @endif

        <form action="{{ route('appointment.store') }}" method="POST" class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            @csrf
            <div class="border-b border-slate-100 px-5 py-5 sm:px-8"><h2 class="text-base font-extrabold">Data Pengajuan</h2><p class="mt-1 text-sm text-slate-500">Kolom bertanda <span class="font-bold text-red-500">*</span> wajib diisi.</p></div>
            <div class="space-y-8 px-5 py-6 sm:px-8 sm:py-8">
                <fieldset>
                    <legend class="mb-3 text-sm font-extrabold text-slate-700">Kategori Pemohon <span class="text-red-500">*</span></legend>
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                        @foreach (['individu' => ['👤', 'Individu / Perorangan', 'Mewakili diri sendiri atau publik'], 'institusi' => ['🏢', 'Institusi / Kelompok', 'Mewakili perusahaan, komunitas, atau instansi']] as $value => $content)
                            <label class="flex min-w-0 cursor-pointer items-start gap-3 rounded-2xl border bg-slate-50 p-4 transition hover:border-indigo-300 {{ old('tipe_pemohon') === $value ? 'border-indigo-600 ring-2 ring-indigo-100' : 'border-slate-200' }}">
                                <input type="radio" name="tipe_pemohon" value="{{ $value }}" required class="mt-1 h-4 w-4 shrink-0 border-slate-300 text-indigo-600 focus:ring-indigo-500" @checked(old('tipe_pemohon') === $value)><span class="text-2xl leading-none">{{ $content[0] }}</span><span class="min-w-0"><span class="block text-sm font-extrabold">{{ $content[1] }}</span><span class="mt-1 block text-xs leading-5 text-slate-500">{{ $content[2] }}</span></span>
                            </label>
                        @endforeach
                    </div>
                    @error('tipe_pemohon') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                </fieldset>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="min-w-0"><label for="instansi" class="mb-2 block text-sm font-extrabold text-slate-700">Instansi Asal / Komunitas <span class="text-red-500">*</span></label><input id="instansi" name="instansi" type="text" value="{{ old('instansi') }}" required placeholder="Contoh: PT Sinar Jaya / Pribadi" class="block w-full rounded-xl border {{ $errors->has('instansi') ? 'border-red-400' : 'border-slate-200' }} bg-slate-50 px-3.5 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100">@error('instansi') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror</div>
                    <div class="min-w-0"><label for="tujuan" class="mb-2 block text-sm font-extrabold text-slate-700">Tujuan Utama <span class="text-red-500">*</span></label><select id="tujuan" name="tujuan" required class="block w-full rounded-xl border {{ $errors->has('tujuan') ? 'border-red-400' : 'border-slate-200' }} bg-slate-50 px-3.5 py-3 text-sm font-semibold outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100"><option value="">Pilih tujuan pertemuan</option>@foreach (['Penandatanganan Dokumen', 'Konsultasi TIK', 'Lainnya'] as $tujuan)<option value="{{ $tujuan }}" @selected(old('tujuan') === $tujuan)>{{ $tujuan }}</option>@endforeach</select>@error('tujuan') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror</div>
                </div>

                <div><label for="alamat" class="mb-2 block text-sm font-extrabold text-slate-700">Alamat Lengkap <span class="text-red-500">*</span></label><input id="alamat" name="alamat" type="text" value="{{ old('alamat') }}" required placeholder="Alamat instansi atau domisili Anda" class="block w-full rounded-xl border {{ $errors->has('alamat') ? 'border-red-400' : 'border-slate-200' }} bg-slate-50 px-3.5 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100">@error('alamat') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror</div>
                <div><label for="detail_tujuan" class="mb-2 block text-sm font-extrabold text-slate-700">Detail Tujuan Pembahasan <span class="text-red-500">*</span></label><textarea id="detail_tujuan" name="detail_tujuan" rows="5" required placeholder="Jelaskan agenda dan poin yang ingin dibahas..." class="block w-full resize-y rounded-xl border {{ $errors->has('detail_tujuan') ? 'border-red-400' : 'border-slate-200' }} bg-slate-50 px-3.5 py-3 text-sm leading-6 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100">{{ old('detail_tujuan') }}</textarea>@error('detail_tujuan') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror</div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <fieldset class="min-w-0"><legend class="mb-2 text-sm font-extrabold text-slate-700">Metode Pertemuan <span class="text-red-500">*</span></legend><div class="grid grid-cols-1 gap-3 sm:grid-cols-2">@foreach (['luring' => 'Luring (Tatap Muka)', 'daring' => 'Daring (Online)'] as $value => $label)<label class="flex min-w-0 cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-3 text-sm font-bold text-slate-700 transition hover:border-indigo-300"><input type="radio" name="mode" value="{{ $value }}" required class="h-4 w-4 shrink-0 border-slate-300 text-indigo-600 focus:ring-indigo-500" @checked(old('mode') === $value)><span class="min-w-0">{{ $label }}</span></label>@endforeach</div>@error('mode') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror</fieldset>
                    <div class="min-w-0"><label for="preferensi_waktu" class="mb-2 block text-sm font-extrabold text-slate-700">Preferensi Waktu <span class="font-medium text-slate-400">(opsional)</span></label><input id="preferensi_waktu" name="preferensi_waktu" type="datetime-local" value="{{ old('preferensi_waktu') }}" class="block w-full min-w-0 rounded-xl border {{ $errors->has('preferensi_waktu') ? 'border-red-400' : 'border-slate-200' }} bg-slate-50 px-3.5 py-3 text-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100">@error('preferensi_waktu') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror</div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:p-5"><p class="mb-3 text-sm font-extrabold text-slate-700">Verifikasi Keamanan <span class="text-red-500">*</span></p><div class="captcha-scale overflow-hidden"><div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key', env('RECAPTCHA_SITE_KEY')) }}"></div></div>@error('g-recaptcha-response') <p class="mt-3 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror</div>
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50 px-5 py-5 sm:flex-row sm:items-center sm:justify-end sm:px-8"><a href="{{ route('user.dashboard') }}" class="rounded-xl px-5 py-3 text-center text-sm font-bold text-slate-600 transition hover:bg-slate-200">Batal</a><button type="submit" class="rounded-xl bg-indigo-600 px-6 py-3 text-sm font-extrabold text-white shadow-lg shadow-indigo-600/20 transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">Kirim Pengajuan</button></div>
        </form>
    </main>
</body>
</html>
