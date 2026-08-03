<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
'admin_id', 'kategori', 'foto', 'judul', 'tanggal', 
        'lokasi', 'lead', 'body', 'closing', 'status', 'alasan_penolakan', 'views'
    ];

    // Relasi untuk mengetahui siapa Admin yang membuat berita ini
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}