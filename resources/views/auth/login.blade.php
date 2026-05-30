<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portal Layanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 md:p-8" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">

    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row z-10 h-auto md:min-h-[550px]">

        <!-- Left Panel: Info & Branding -->
        <div class="hidden md:flex md:w-5/12 flex-col items-center justify-center p-10 relative overflow-hidden text-center" style="background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);">
            <div class="absolute top-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-80 h-80 bg-white opacity-10 rounded-full translate-x-1/3 translate-y-1/3"></div>

            <img src="{{ asset('logo.png') }}" alt="Logo Kemlu" class="w-130 h-auto mb-8 z-10 drop-shadow-lg">

            <h2 class="text-3xl font-extrabold text-white mb-3 z-10 tracking-wide">Portal Layanan</h2>
            <p class="text-blue-100 text-sm z-10 leading-relaxed px-4">
                Sistem Terpadu Manajemen Kebijakan & Appointment Kementerian Luar Negeri Republik Indonesia. <br>
            </p>
        </div>

        <!-- Right Panel: Login Form -->
        <div class="w-full md:w-7/12 p-8 md:p-12 bg-white flex flex-col justify-center">

            <h2 class="text-2xl font-extrabold text-slate-800 mb-1">Selamat Datang</h2>
            <p class="text-sm text-slate-500 mb-8">Silakan masuk ke akun Anda</p>

            @if(session('error'))
                <div class="mb-6 font-medium text-sm text-red-600 bg-red-50 p-3 rounded-lg border border-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email Resmi</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-lg p-3.5 text-sm transition placeholder:text-slate-400" 
                        placeholder="email@instansi.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-lg p-3.5 text-sm transition placeholder:text-slate-400" 
                        placeholder="••••••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                </div>

                <div class="flex items-center justify-between pt-2">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ms-2 text-sm text-slate-600">Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition" href="{{ route('password.request') }}">
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <!-- Google reCAPTCHA Widget -->
                <div class="mt-4 mb-4">
                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    @error('g-recaptcha-response')
                        <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 px-4 rounded-lg transition duration-200 mt-4 tracking-wide text-sm shadow-md">
                    MASUK KE SISTEM
                </button>
            </form>

            <div class="mt-6 flex items-center justify-center space-x-4">
                <span class="h-px w-full bg-slate-200"></span>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">ATAU</span>
                <span class="h-px w-full bg-slate-200"></span>
            </div>

            <div class="mt-6">
                <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center gap-3 bg-white border-2 border-slate-200 hover:bg-slate-50 text-slate-700 font-bold py-3 px-4 rounded-lg transition duration-200 text-sm shadow-sm">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Masuk Otomatis via Akun Google Resmi
                </a>
            </div>

            @if (Route::has('register'))
                <div class="mt-8 text-center">
                    <a href="{{ route('register') }}" class="text-sm font-medium text-slate-500 hover:text-indigo-600 transition">
                        Belum punya akun? Daftar di sini
                    </a>
                </div>
            @endif

        </div>
    </div>
</body>
</html>