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
    }
    // Default untuk user
    return redirect()->route('user.dashboard');
})->middleware(['auth'])->name('dashboard');

// === RUTE UNTUK LOGIN GOOGLE SSO ===
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// === GRUP RUTE YANG WAJIB LOGIN ===
Route::middleware('auth')->group(function () {
    
    // Rute Profil Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 1. RUTE KHUSUS USER BIASA
    Route::middleware('role:user')->group(function () {
        // Dasbor User (Sekarang aman di dalam perlindungan role:user)
        Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
        
        // Rute Appointment (Sekarang sinkron dengan tombol di Dasbor)
        Route::get('/appointment/create', [\App\Http\Controllers\AppointmentController::class, 'create'])->name('appointment.create');
        Route::post('/appointment/store', [\App\Http\Controllers\AppointmentController::class, 'store'])->name('appointment.store');
    });

    // 2. RUTE KHUSUS ADMIN (Operasional)
    Route::middleware('role:admin,super_admin')->prefix('admin')->name('admin.')->group(function () {
        
        // SATUKAN SEMUANYA KE FUNGSI INDEX (SPA)
        Route::get('/appointment', [AdminController::class, 'index'])->name('appointment');
        
        // Rute Simpan Form Kebijakan
        Route::post('/kebijakan/mou', [AdminController::class, 'storeMou'])->name('mou.store');
        Route::post('/kebijakan/tik-kemlu', [AdminController::class, 'storeTikKemlu'])->name('tik_kemlu.store');
        Route::post('/kebijakan/tik-non-kemlu', [AdminController::class, 'storeTikNonKemlu'])->name('tik_non_kemlu.store');
        
        // RUTE BARU: Simpan Form Berita
        Route::post('/berita/store', [AdminController::class, 'storeBerita'])->name('berita.store');
        
        // Rute Update Status
        Route::patch('/appointment/{id}/status', [AdminController::class, 'updateAppointmentStatus'])->name('appointment.update_status');
    });

    // 2.5 RUTE API CERDAS UNTUK ADMIN (FITUR AI)
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // RUTE API CERDAS
        Route::post('/api/berita/translate', [App\Http\Controllers\AdminController::class, 'translateApi']);
        Route::post('/api/berita/generate-lead', [App\Http\Controllers\AdminController::class, 'generateLeadApi']);
        Route::get('/api/berita/radar-global', [App\Http\Controllers\AdminController::class, 'radarGlobalApi']);
    });

    // 3. RUTE SANGAT KHUSUS SUPER ADMIN (Pimpinan)
    Route::middleware('role:super_admin')->prefix('super-admin')->name('super_admin.')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');
        Route::get('/rekap-jadwal', [SuperAdminController::class, 'rekapJadwal'])->name('rekap_jadwal'); // Added for Super Admin
        
        // Rute untuk mengelola akun Admin
        Route::post('/admin/store', [SuperAdminController::class, 'storeAdmin'])->name('admin.store');
        Route::delete('/admin/{id}', [SuperAdminController::class, 'destroyAdmin'])->name('admin.destroy');

        // Rute dinamis untuk review ketiga jenis kebijakan
        Route::patch('/kebijakan/review/{kategori}/{id}', [SuperAdminController::class, 'reviewKebijakan'])->name('kebijakan.review');
        
        // RUTE BARU: untuk review Berita
        Route::patch('/berita/review/{id}', [SuperAdminController::class, 'reviewBerita'])->name('berita.review');
    });

});

// Rute darurat jika Anda tersangkut saat mau logout
Route::get('/logout-manual', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});

require __DIR__.'/auth.php';