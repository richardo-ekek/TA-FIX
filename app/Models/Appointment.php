<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'tipe_pemohon',
        'admin_id',
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
        'keterangan_tambahan', 
        'link_maps', 
        'detail_alamat_pertemuan', 
        'alasan_penolakan'
    ];

    // Relasi balik ke tabel Users (Untuk mengetahui User/Pemohon)
    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    // Relasi untuk mengetahui Admin siapa yang memproses/menyetujui janji temu ini
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}