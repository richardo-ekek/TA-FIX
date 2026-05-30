<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    /**
     * Kolom yang bisa di-mass assign
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id', 'nama', 'alamat', 'pekerjaan', 'tempat_lahir', 'tanggal_lahir'
    ];

    /**
     * Relasi ke User (N:1)
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
