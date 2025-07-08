<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
