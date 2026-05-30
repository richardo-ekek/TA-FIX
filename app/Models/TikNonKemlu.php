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
        // --- 2 Baris Izin Baru di Bawah Ini ---
        'alasan_penolakan',
        'keterangan_tambahan'
    ];

    public function logs() {
        return $this->morphMany(ActivityLog::class, 'model');
    }
}