<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouPks extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis', 
        'perihal', 
        'satker_kemlu', 
        'instansi_external', 
        'tanggal_disahkan', 
        'tanggal_berakhir', 
        'status', 
        'keterangan',
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