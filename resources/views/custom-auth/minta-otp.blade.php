<form method="POST" action="{{ route('custom.send_otp') }}">
    @csrf
    <h2>Lupa Password</h2>
    
    @if(session('error')) <p style="color:red">{{ session('error') }}</p> @endif
    
    <label>Masukkan Email Anda:</label><br>
    <input type="email" name="email" required><br><br>
    <button type="submit">Kirim OTP ke Email</button>
</form>