<nav class="bg-white border-b border-gray-100 shadow-sm relative z-50 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            
            <div class="flex items-center">
                <a href="{{ route('user.dashboard') ?? url('/user/dashboard') }}" class="flex items-center gap-3 group">
                    <div class="hidden sm:flex flex-col">
                        <span class="font-extrabold text-indigo-950 text-xl tracking-tight leading-tight">Portal Layanan</span>
                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-widest">Pusat Komando</span>
                    </div>
                </a>
            </div>

            <div class="flex items-center gap-4">
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin keluar dari sistem?');" 
                            class="inline-flex items-center gap-2 bg-red-50 text-red-600 hover:bg-red-500 hover:text-white px-4 py-2 rounded-lg text-sm font-bold transition duration-200 shadow-sm border border-red-100 hover:border-red-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>