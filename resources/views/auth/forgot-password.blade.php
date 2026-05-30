<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Pusat Komando SPA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <div class="flex justify-center mb-10">
            <div class="bg-white p-4 rounded-[2rem] shadow-2xl shadow-slate-200 border border-slate-100">
                <img src="{{ asset('logo.png') }}" alt="Logo Kemenlu" class="h-28 w-auto object-contain">
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-8 md:p-10">
                <h2 class="text-2xl font-black text-slate-800 mb-2 text-center">Lupa Password?</h2>
                <p class="text-sm text-slate-500 text-center mb-8 leading-relaxed">
                    Masukkan alamat email Anda yang terdaftar dan kami akan mengirimkan tautan untuk mengatur ulang password Anda.
                </p>

                @if (session('status'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl text-sm font-bold flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-[11px] font-extrabold text-slate-400 uppercase tracking-widest mb-2 ml-1">Alamat Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                            </span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@instansi.go.id" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 pl-12 pr-4 text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition-all">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-2 font-bold ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-center">
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    </div>
                    @error('g-recaptcha-response')
                        <p class="text-red-500 text-xs mt-1 text-center font-bold">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="w-full bg-slate-900 hover:bg-indigo-700 text-white font-extrabold py-4 rounded-2xl shadow-lg shadow-slate-200 transition-all flex justify-center items-center gap-2 group">
                        Kirim Tautan Reset
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>

            <div class="bg-slate-50 border-t border-slate-100 p-6 text-center">
                <a href="{{ route('login') }}" class="text-xs font-bold text-slate-400 hover:text-indigo-600 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Login
                </a>
            </div>
        </div>

        <p class="mt-8 text-center text-[10px] text-slate-400 font-bold uppercase tracking-widest">
            &copy; 2026 Portal Internal Kemenlu RI
        </p>
    </div>

</body>
</html>