<!-- UBAH ACTION INI -->
<form method="POST" action="{{ route('otp.store_password') }}">
    @csrf

    <h3>Buat Password Baru</h3>
    <p>Akun: <strong>{{ $email }}</strong></p>

    <!-- Menyimpan email secara hidden -->
    <input type="hidden" name="email" value="{{ $email }}">

    <div style="margin-bottom: 15px;">
        <label for="password">Password Baru</label><br>
        <input id="password" type="password" name="password" required autofocus>
    </div>

    <div style="margin-bottom: 15px;">
        <label for="password_confirmation">Konfirmasi Password Baru</label><br>
        <input id="password_confirmation" type="password" name="password_confirmation" required>
    </div>
    
    @if ($errors->any())
        <div style="color: red; margin-bottom: 15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <button type="submit">Simpan Password</button>
</form>