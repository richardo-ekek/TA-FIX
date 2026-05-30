<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    /**
     * Kolom yang bisa di-mass assign
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id', 
        'admin_name', 
        'kategori_dokumen', 
        'perihal_dokumen', 
        'aksi', 
        'catatan'
    ];

    /**
     * Casting atribut
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'snapshot' => 'array', // Dihapus karena tidak ada di struktur tabel baru
    ];

    /**
     * Relasi ke User (N:1)
     */
    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    // Method morphTo tidak diperlukan karena tidak menggunakan polymorphic relations
}