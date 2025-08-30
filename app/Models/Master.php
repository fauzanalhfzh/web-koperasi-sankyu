<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    use HasFactory;

    protected $fillable = [
        'saving_id',
        'loan_id',
        'jenis_simpanan',
        'jumlah_simpanan',
        'jumlah_pinjaman',
    ];

    public function simpanan()
    {
        return $this->belongsTo(Saving::class);
    }

    public function pinjaman()
    {
        return $this->belongsTo(Loan::class);
    }
}
