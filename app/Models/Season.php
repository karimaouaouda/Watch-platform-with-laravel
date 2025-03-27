<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = [
        'title',
        'series_id',
        'season_number',
        'release_date',
        'description'
    ];
}
