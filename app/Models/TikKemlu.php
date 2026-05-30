<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TikKemlu extends Model
{
    use HasFactory;

    // Memastikan Laravel membaca nama tabel yang tepat
    protected $table = 'tik_kemlu';

    protected $fillable = [
        'jenis_kebijakan', 
        'nomor_kebijakan', 
        'tahun', 
        'perihal', 
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