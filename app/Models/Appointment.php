<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // INI ADALAH KUNCI PERIZINANNYA (MASS ASSIGNMENT)
    protected $fillable = [
        'user_id', 
        'nama', 
        'instansi', 
        'alamat', 
        'tujuan', 
        'detail_tujuan', 
        'mode', 
        'preferensi_waktu', 
        'status', 
        'link_meeting', 
        'alamat_pertemuan', 
        'tanggal_waktu_pertemuan',

        // Tambahan Baru:
        'keterangan_tambahan', 
        'link_maps', 
        'detail_alamat_pertemuan', 
        'alasan_penolakan'
    ];

    // Relasi balik ke tabel Users
    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}