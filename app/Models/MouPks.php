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
        // --- 2 Baris Izin Baru di Bawah Ini ---
        'alasan_penolakan',
        'keterangan_tambahan'
    ];

    public function logs() {
        return $this->morphMany(ActivityLog::class, 'model');
    }
}