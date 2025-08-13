<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable; // ✅ ganti base class
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use SoftDeletes, HasFactory, Notifiable; // ✅ tambahkan Notifiable kalau mau pakai fitur notifikasi

    protected $guarded = [];

    protected $dates = ['tanggal_simpanan', 'tanggal_pinjaman'];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function simpanan()
    {
        return $this->hasMany(Saving::class);
    }

    public function pinjaman()
    {
        return $this->hasMany(Loan::class);
    }
}
