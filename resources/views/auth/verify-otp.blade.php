<!-- UBAH ACTION INI -->
<form method="POST" action="{{ route('otp.verify') }}">
    @csrf
    
    <input type="hidden" name="email" value="{{ request('email') ?? session('email_sementara') }}">

    <div>
        <label for="otp">Masukkan Kode OTP</label>
        <input type="text" id="otp" name="otp" required autofocus>
    </div>

    @error('otp')
        <div style="color: red;">{{ $message }}</div>
    @enderror

    <button type="submit">Verifikasi OTP</button>
</form>