<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;

// Halaman Utama (Arahkan ke login)
Route::get('/', function () {
    return redirect()->route('login');
});

// === GERBANG UTAMA (TRAFFIC CONTROLLER BREEZE) ===
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    if ($role === 'super_admin') {
        return redirect('/super-admin/dashboard');
    } elseif ($role === 'admin') {
        return redirect('/admin/appointment');
    } elseif ($role === 'tim_hukum') {
        return redirect('/tim-hukum/dashboard'); // Arahkan ke dasbor Tim Hukum
    }

    return redirect()->route('user.dashboard');
})->middleware(['auth'])->name('dashboard');

// === RUTE UNTUK LOGIN GOOGLE SSO ===
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// ======================================================
// RUTE LUPA PASSWORD OTP (DENGAN VALIDASI DATABASE & GMAIL)
// ======================================================
Route::get('/lupa-password-otp', function () {
    return view('auth.lupa-password-otp');
})->name('lupa-password-otp');

// Simulasi validasi nomor telepon
Route::post('/check-phone-otp', [ProfileController::class, 'checkPhoneOtp'])
    ->name('check.phone.otp');

// Kirim OTP ke Gmail
Route::post('/send-email-otp', [ProfileController::class, 'sendEmailOtp'])
    ->name('send.email.otp');

// Verifikasi OTP dari Gmail
Route::post('/verify-email-otp', [ProfileController::class, 'verifyEmailOtp'])
    ->name('verify.email.otp');

// Rute untuk mencatat jumlah klik/views dokumen
Route::post('/record-view', [UserController::class, 'recordView'])->name('record.view');

// Simpan Password Baru setelah OTP berhasil
Route::post('/simpan-password-baru', [ProfileController::class, 'resetPasswordFinal'])
    ->name('password.store');

// === GRUP RUTE YANG WAJIB LOGIN ===
Route::middleware('auth')->group(function () {

    // ======================================================
    // RUTE GANTI PASSWORD UNTUK SEMUA ROLE
    // ======================================================
    Route::post('/update-password', [ProfileController::class, 'updatePasswordCustom'])
        ->name('password.custom.update');

    // ======================================================
    // RUTE LENGKAPI / UPDATE PROFIL
    // ======================================================
    Route::post('/update-profile-detail', [ProfileController::class, 'updateProfileDetail'])
        ->name('profile.custom.update_detail');

    // ======================================================
    // RUTE UPDATE FOTO PROFIL (TAMBAHAN BARU TAHAP 2)
    // ======================================================
    Route::post('/update-foto-profil', [ProfileController::class, 'updateFotoProfil'])
        ->name('profile.update_foto');

    // ======================================================
    // RUTE RECORD VIEW COUNTER (TAMBAHAN BARU TAHAP 2)
    // ======================================================
    Route::post('/record-view', [UserController::class, 'recordView'])
        ->name('record.view');

    // ======================================================
    // Rute Profil Bawaan Breeze
    // ======================================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ======================================================
    // 1. RUTE KHUSUS USER BIASA
    // ======================================================
    Route::middleware('role:user')->group(function () {

        // Dasbor User
        Route::get('/user/dashboard', [UserController::class, 'dashboard'])
            ->name('user.dashboard');

        // Appointment
        Route::get('/appointment/create', [App\Http\Controllers\AppointmentController::class, 'create'])
            ->name('appointment.create');

        Route::post('/appointment/store', [App\Http\Controllers\AppointmentController::class, 'store'])
            ->name('appointment.store');
    });

    // ======================================================
    // 2. RUTE KHUSUS ADMIN (Operasional)
    // ======================================================
    Route::middleware('role:admin,super_admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // Dashboard Admin (SPA)
            Route::get('/appointment', [AdminController::class, 'index'])
                ->name('appointment');

            // Simpan Kebijakan (Data Baru)
            Route::post('/kebijakan/mou', [AdminController::class, 'storeMou'])
                ->name('mou.store');

            Route::post('/kebijakan/tik-kemlu', [AdminController::class, 'storeTikKemlu'])
                ->name('tik_kemlu.store');

            Route::post('/kebijakan/tik-non-kemlu', [AdminController::class, 'storeTikNonKemlu'])
                ->name('tik_non_kemlu.store');

            // Simpan Berita (Data Baru)
            Route::post('/berita/store', [AdminController::class, 'storeBerita'])
                ->name('berita.store');

// Rute Khusus untuk Mengirim Data Revisi (Bisa menerima PUT & PATCH)
Route::match(['put', 'patch'], '/kebijakan/update/{kategori}/{id}', [AdminController::class, 'updateKebijakan'])->name('kebijakan.update');
Route::match(['put', 'patch'], '/berita/update/{id}', [AdminController::class, 'updateBerita'])->name('berita.update');

            // --- RUTE BARU TAHAP 3: Edit / Submit Ulang (Revisi) ---
            Route::patch('/kebijakan/mou/{id}', [AdminController::class, 'updateMou'])
                ->name('mou.update');
            
            Route::patch('/kebijakan/tik-kemlu/{id}', [AdminController::class, 'updateTikKemlu'])
                ->name('tik_kemlu.update');
            
            Route::patch('/kebijakan/tik-non-kemlu/{id}', [AdminController::class, 'updateTikNonKemlu'])
                ->name('tik_non_kemlu.update');
            
            Route::patch('/berita/update/{id}', [AdminController::class, 'updateBerita'])
                ->name('berita.update');
            // --------------------------------------------------------

            // Update Status Appointment
            Route::patch('/appointment/{id}/status', [AdminController::class, 'updateAppointmentStatus'])
                ->name('appointment.update_status');
        });

    // ======================================================
    // 2.5 RUTE API CERDAS UNTUK ADMIN (FITUR AI)
    // ======================================================
    Route::middleware(['auth', 'role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::post('/api/berita/translate', [AdminController::class, 'translateApi']);
            Route::post('/api/berita/generate-lead', [AdminController::class, 'generateLeadApi']);
            Route::get('/api/berita/radar-global', [AdminController::class, 'radarGlobalApi']);
        });

    // ======================================================
    // 3. RUTE KHUSUS SUPER ADMIN
    // ======================================================
    Route::middleware('role:super_admin')
        ->prefix('super-admin')
        ->name('super_admin.')
        ->group(function () {

            Route::get('/dashboard', [SuperAdminController::class, 'index'])
                ->name('dashboard');

            Route::get('/rekap-jadwal', [SuperAdminController::class, 'rekapJadwal'])
                ->name('rekap_jadwal');

            // Kelola Admin
            Route::post('/admin/store', [SuperAdminController::class, 'storeAdmin'])
                ->name('admin.store');

            Route::delete('/admin/{id}', [SuperAdminController::class, 'destroyAdmin'])
                ->name('admin.destroy');

            // Review Kebijakan
            Route::patch('/kebijakan/review/{kategori}/{id}', [SuperAdminController::class, 'reviewKebijakan'])
                ->name('kebijakan.review');

            // Review Berita
            Route::patch('/berita/review/{id}', [SuperAdminController::class, 'reviewBerita'])
                ->name('berita.review');
        });

        // ======================================================
// RUTE KHUSUS TIM HUKUM (LEGAL)
// ======================================================
Route::middleware('role:tim_hukum')
    ->prefix('tim-hukum')
    ->name('tim_hukum.')
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\TimHukumController::class, 'index'])->name('dashboard');
        Route::patch('/review/{kategori}/{id}', [App\Http\Controllers\TimHukumController::class, 'prosesReview'])->name('review');
    });
});

// ======================================================
// Logout Manual
// ======================================================
Route::get('/logout-manual', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
});

require __DIR__ . '/auth.php';