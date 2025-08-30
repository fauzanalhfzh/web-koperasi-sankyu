<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Saving extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = [];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function master()
    {
        return $this->hasMany(Master::class);
    }
}
