<form method="POST" action="{{ route('custom.verify_otp') }}">
    @csrf
    <h2>Verifikasi OTP</h2>
    <p>Cek email Anda: <strong>{{ $email }}</strong></p>
    
    @if(session('error')) <p style="color:red">{{ session('error') }}</p> @endif

    <!-- Email disembunyikan agar dikirim kembali -->
    <input type="hidden" name="email" value="{{ $email }}">

    <label>Masukkan Kode OTP:</label><br>
    <input type="text" name="otp" required><br><br>
    <button type="submit">Validasi Kode</button>
</form>