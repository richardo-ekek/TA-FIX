<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password - Portal SPA Kemlu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .fade-in { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Ornamen Background Latar Belakang -->
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>

    <div class="bg-white p-8 md:p-10 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 w-full max-w-md relative z-10 border border-slate-100">
        
        <!-- Logo / Header Ringkas -->
        <div class="flex justify-center mb-8">
            <div class="bg-indigo-50 text-indigo-600 px-4 py-2 rounded-full text-[10px] font-extrabold uppercase tracking-widest border border-indigo-100 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Pemulihan Akun
            </div>
        </div>

        <!-- STEP 1: PILIH METODE (Halaman Awal) -->
        <div id="step-1-method" class="fade-in">
            <h2 class="text-2xl font-black text-slate-800 mb-2 text-center">Lupa Kata Sandi?</h2>
            <p class="text-slate-500 text-sm mb-8 text-center leading-relaxed">Jangan khawatir! Pilih metode pemulihan di bawah ini untuk mengatur ulang sandi Anda.</p>
            
            <div class="space-y-4">
                <!-- Tombol Opsi Email -->
                <button onclick="goToInput('email')" class="w-full text-left bg-white border-2 border-slate-100 hover:border-indigo-500 p-4 rounded-2xl transition-all duration-300 group hover:shadow-lg hover:shadow-indigo-100 flex items-center gap-4">
                    <div class="bg-indigo-50 p-4 rounded-xl text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <span class="block font-bold text-slate-800 group-hover:text-indigo-700 transition-colors">Via Email Utama</span>
                        <span class="text-[11px] text-slate-400 font-medium">Kirim kode OTP ke Kotak Masuk</span>
                    </div>
                </button>

                <!-- Tombol Opsi Telepon -->
                <button onclick="goToInput('phone')" class="w-full text-left bg-white border-2 border-slate-100 hover:border-emerald-500 p-4 rounded-2xl transition-all duration-300 group hover:shadow-lg hover:shadow-emerald-100 flex items-center gap-4">
                    <div class="bg-emerald-50 p-4 rounded-xl text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <span class="block font-bold text-slate-800 group-hover:text-emerald-700 transition-colors">Via SMS / Telepon</span>
                        <span class="text-[11px] text-slate-400 font-medium">Kirim kode OTP ke Nomor Anda</span>
                    </div>
                </button>
            </div>
            
            <a href="{{ route('login') }}" class="block text-center mt-8 text-sm font-bold text-slate-400 hover:text-indigo-600 transition-colors">Kembali ke Halaman Login</a>
        </div>

        <!-- STEP 2A: INPUT UNTUK EMAIL -->
        <div id="step-2-email" class="hidden fade-in">
            <button onclick="backToMethod()" class="text-slate-400 hover:text-indigo-600 mb-6 flex items-center gap-1 text-sm font-bold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg> Kembali
            </button>
            <h2 class="text-2xl font-black text-slate-800 mb-2">Pemulihan Email</h2>
            <p class="text-slate-500 text-sm mb-6 leading-relaxed">Masukkan alamat email yang terdaftar pada akun Anda untuk menerima kode sandi.</p>
            
            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-widest mb-2 pl-1">Email Terdaftar</label>
                    <input type="email" id="emailOnlyInput" class="w-full bg-slate-50 border border-slate-200 p-4 rounded-xl text-sm outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-slate-800" placeholder="contoh@kemlu.go.id">
                </div>
            </div>
            <button onclick="processEmailMethod()" id="btn-submit-email" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold py-4 rounded-xl shadow-lg shadow-indigo-200 transition-all flex justify-center items-center gap-2">
                Kirim Kode OTP
            </button>
        </div>

        <!-- STEP 2B: INPUT UNTUK NOMOR TELEPON -->
        <div id="step-2-phone" class="hidden fade-in">
            <button onclick="backToMethod()" class="text-slate-400 hover:text-emerald-600 mb-6 flex items-center gap-1 text-sm font-bold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg> Kembali
            </button>
            <h2 class="text-2xl font-black text-slate-800 mb-2">Pemulihan Telepon</h2>
            <p class="text-slate-500 text-sm mb-6 leading-relaxed">Demi keamanan, verifikasi bahwa ini adalah Anda dengan memasukkan Email dan Nomor Telepon.</p>
            
            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-widest mb-2 pl-1">Email Terdaftar</label>
                    <input type="email" id="phoneEmailInput" class="w-full bg-slate-50 border border-slate-200 p-4 rounded-xl text-sm outline-none focus:ring-2 focus:ring-emerald-500 transition-all font-medium text-slate-800" placeholder="contoh@kemlu.go.id">
                </div>
                <div>
                    <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-widest mb-2 pl-1">Nomor Telepon</label>
                    <input type="text" id="phoneOnlyInput" class="w-full bg-slate-50 border border-slate-200 p-4 rounded-xl text-sm outline-none focus:ring-2 focus:ring-emerald-500 transition-all font-medium text-slate-800" placeholder="081234567890">
                </div>
            </div>
            <button onclick="processPhoneMethod()" id="btn-submit-phone" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold py-4 rounded-xl shadow-lg shadow-emerald-200 transition-all flex justify-center items-center gap-2">
                Verifikasi & Kirim SMS
            </button>
        </div>

        <!-- STEP 3: INPUT KODE OTP -->
        <div id="step-3-otp" class="hidden fade-in">
            <div class="flex justify-center mb-4">
                <div class="bg-indigo-50 p-4 rounded-full text-indigo-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <h2 class="text-2xl font-black text-slate-800 mb-2 text-center">Masukkan OTP</h2>
            <p class="text-slate-500 text-sm mb-8 text-center" id="otp-message">Kami telah mengirimkan 4 digit kode OTP.</p>
            
            <div class="flex justify-center gap-3 md:gap-4 mb-8">
                <input type="text" id="otp-1" maxlength="1" class="otp-input w-14 h-14 md:w-16 md:h-16 text-center text-2xl font-black text-indigo-700 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:border-indigo-500 focus:ring-0 outline-none transition-all">
                <input type="text" id="otp-2" maxlength="1" class="otp-input w-14 h-14 md:w-16 md:h-16 text-center text-2xl font-black text-indigo-700 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:border-indigo-500 focus:ring-0 outline-none transition-all">
                <input type="text" id="otp-3" maxlength="1" class="otp-input w-14 h-14 md:w-16 md:h-16 text-center text-2xl font-black text-indigo-700 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:border-indigo-500 focus:ring-0 outline-none transition-all">
                <input type="text" id="otp-4" maxlength="1" class="otp-input w-14 h-14 md:w-16 md:h-16 text-center text-2xl font-black text-indigo-700 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:border-indigo-500 focus:ring-0 outline-none transition-all">
            </div>
            
            <button onclick="verifyOTPFinal()" id="btn-verify-final" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-extrabold py-4 rounded-xl shadow-lg shadow-slate-300 transition-all">
                Verifikasi Kode
            </button>
            <button onclick="backToMethod()" class="mt-6 text-sm font-bold text-slate-400 hover:text-slate-600 block text-center w-full transition-colors">Pilih Metode Lain</button>
        </div>

        <!-- STEP 4 BARU: FORM PASSWORD BARU -->
        <div id="step-4-password" class="hidden fade-in">
            <h2 class="text-2xl font-black text-slate-800 mb-2 text-center">Buat Password Baru</h2>
            <p class="text-slate-500 text-sm mb-6 text-center leading-relaxed">Verifikasi berhasil! Silakan buat kata sandi baru untuk akun Anda.</p>

            <!-- Pastikan nama route ini sesuai dengan route POST untuk simpan password di backend Anda -->
            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                
                <!-- Email dan OTP disembunyikan untuk dikirim bersamaan -->
                <input type="hidden" name="email" id="final-email">
                <input type="hidden" name="otp" id="final-otp">

                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-widest mb-2 pl-1">Password Baru</label>
                        <input type="password" name="password" required class="w-full bg-slate-50 border border-slate-200 p-4 rounded-xl text-sm outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-slate-800" placeholder="Minimal 8 karakter">
                    </div>
                    <div>
                        <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-widest mb-2 pl-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required class="w-full bg-slate-50 border border-slate-200 p-4 rounded-xl text-sm outline-none focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-slate-800" placeholder="Ulangi password baru">
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold py-4 rounded-xl shadow-lg shadow-indigo-200 transition-all flex justify-center items-center gap-2">
                    Simpan & Login
                </button>
            </form>
        </div>

    </div>

    <script>
        let currentEmail = '';
        let activeMethod = '';

        // Fungsi Transisi Antar Langkah
        function switchView(hideId, showId) {
            document.getElementById(hideId).classList.add('hidden');
            document.getElementById(showId).classList.remove('hidden');
        }

        // Langkah 1: Pilih Metode ke Input
        function goToInput(method) {
            activeMethod = method;
            if (method === 'email') {
                switchView('step-1-method', 'step-2-email');
                document.getElementById('emailOnlyInput').focus();
            } else {
                switchView('step-1-method', 'step-2-phone');
                document.getElementById('phoneEmailInput').focus();
            }
        }

        // Kembali ke Langkah 1
        function backToMethod() {
            document.getElementById('step-2-email').classList.add('hidden');
            document.getElementById('step-2-phone').classList.add('hidden');
            document.getElementById('step-3-otp').classList.add('hidden');
            document.getElementById('step-4-password').classList.add('hidden'); // Sembunyikan form password
            
            document.getElementById('step-1-method').classList.remove('hidden');
            activeMethod = ''; currentEmail = '';
        }

        // Proses Metode Email (Kirim SMTP Asli)
        async function processEmailMethod() {
            const email = document.getElementById('emailOnlyInput').value;
            if(!email) return alert('Email wajib diisi!');
            currentEmail = email;

            const btn = document.getElementById('btn-submit-email');
            btn.innerHTML = `<svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengirim OTP...`;
            btn.disabled = true;

            try {
                const response = await fetch('/send-email-otp', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ email: currentEmail })
                });
                const data = await response.json();
                
                btn.innerHTML = 'Kirim Kode OTP'; btn.disabled = false;

                if(data.success) {
                    document.getElementById('otp-message').innerHTML = `Kode OTP telah dikirim ke kotak masuk <b>${currentEmail}</b>`;
                    switchView('step-2-email', 'step-3-otp');
                    document.getElementById('otp-1').focus();
                } else {
                    alert(data.message);
                }
            } catch (err) {
                alert('Gagal mengirim email OTP. Periksa koneksi internet Anda.');
                btn.innerHTML = 'Kirim Kode OTP'; btn.disabled = false;
            }
        }

        // Proses Metode Telepon (Cek DB -> Simulasi SMS)
        async function processPhoneMethod() {
            const email = document.getElementById('phoneEmailInput').value;
            const phone = document.getElementById('phoneOnlyInput').value;
            
            if(!email || !phone) return alert('Email dan Nomor Telepon wajib diisi!');
            currentEmail = email;

            const btn = document.getElementById('btn-submit-phone');
            btn.innerHTML = `<svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memeriksa Data...`;
            btn.disabled = true;

            try {
                const response = await fetch('/check-phone-otp', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ email: currentEmail, no_telp: phone })
                });
                const data = await response.json();
                
                if (data.success) {
                    btn.innerHTML = "Nomor Cocok! Mengirim SMS...";
                    setTimeout(() => {
                        document.getElementById('otp-message').innerHTML = `Kami telah mensimulasikan pengiriman kode SMS ke nomor <b>${phone}</b>`;
                        switchView('step-2-phone', 'step-3-otp');
                        document.getElementById('otp-1').focus();
                        btn.innerHTML = 'Verifikasi & Kirim SMS'; btn.disabled = false;
                    }, 1000);
                } else {
                    alert(data.message); 
                    btn.innerHTML = 'Verifikasi & Kirim SMS'; btn.disabled = false;
                }
            } catch (error) {
                alert('Terjadi kesalahan saat memverifikasi data.');
                btn.innerHTML = 'Verifikasi & Kirim SMS'; btn.disabled = false;
            }
        }

        // Verifikasi Akhir
        async function verifyOTPFinal() {
            const otpCode = document.getElementById('otp-1').value + document.getElementById('otp-2').value + document.getElementById('otp-3').value + document.getElementById('otp-4').value;
            if (otpCode.length < 4) return alert('Masukkan 4 digit OTP dengan lengkap.');

            const btn = document.getElementById('btn-verify-final');
            const originalText = btn.innerText;
            btn.innerText = "Memverifikasi..."; btn.disabled = true;

            if (activeMethod === 'email') {
                try {
                    const response = await fetch('/verify-email-otp', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                        body: JSON.stringify({ email: currentEmail, otp: otpCode })
                    });
                    const data = await response.json();
                    
                    if(data.success) {
                        // PERUBAHAN: Jangan lempar ke halaman login, tapi tampilkan Form Step 4!
                        document.getElementById('final-email').value = currentEmail;
                        document.getElementById('final-otp').value = otpCode;
                        switchView('step-3-otp', 'step-4-password');
                    } else {
                        alert(data.message);
                        btn.innerText = originalText; btn.disabled = false;
                    }
                } catch (err) { 
                    alert('Kesalahan jaringan'); 
                    btn.innerText = originalText; btn.disabled = false; 
                }
            } else {
                // Mockup OTP simulasi Telp (Apapun inputnya akan dianggap berhasil selama 4 digit)
                setTimeout(() => {
                    // PERUBAHAN: Jangan lempar ke halaman login, tapi tampilkan Form Step 4!
                    document.getElementById('final-email').value = currentEmail;
                    document.getElementById('final-otp').value = otpCode;
                    switchView('step-3-otp', 'step-4-password');
                }, 800);
            }
        }

        // Logika Perpindahan Otomatis Kotak OTP
        document.querySelectorAll('.otp-input').forEach((input, index, inputs) => {
            input.addEventListener('input', (e) => { 
                e.target.value = e.target.value.replace(/[^0-9]/g, '');
                if(e.target.value.length === 1 && index < inputs.length - 1) inputs[index + 1].focus(); 
            });
            input.addEventListener('keydown', (e) => { 
                if(e.key === 'Backspace' && !e.target.value && index > 0) inputs[index - 1].focus(); 
            });
        });
    </script>
</body>
</html>