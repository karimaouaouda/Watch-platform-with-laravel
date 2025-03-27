<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{

    protected $fillable = [
        'code',
        'device_id',
        'duration',
        'status',
        'used_at',
    ];
}
