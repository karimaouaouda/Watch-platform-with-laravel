<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $fillable = [
        'title',
        'description',
        'season_id',
        'episode_number',
        'url',
        'poster_url'
    ];
}
