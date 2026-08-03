<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TikNonKemlu extends Model
{
    use HasFactory;

    protected $table = 'tik_non_kemlu';

    protected $fillable = [
        'jenis_kebijakan', 
        'nomor_kebijakan', 
        'tahun', 
        'perihal', 
        'instansi', 
        'tautan', 
        'status',
        'alasan_penolakan',
        'keterangan_tambahan',
        'admin_id',
        'tim_hukum_id',
        'super_admin_id',
        'file_berita_acara',
        'views'
    ];

    public function logs() {
        return $this->morphMany(ActivityLog::class, 'model');
    }

    // --- Relasi ke Aktor (Admin, Tim Hukum, Super Admin) ---
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function timHukum()
    {
        return $this->belongsTo(User::class, 'tim_hukum_id');
    }

    public function superAdmin()
    {
        return $this->belongsTo(User::class, 'super_admin_id');
    }
}