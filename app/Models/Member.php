<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function simpanan()
    {
        return $this->hasMany(Saving::class);
    }

    public function pinjaman()
    {
        return $this->hasMany(Loan::class);
    }
}
