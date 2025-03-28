<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $fillable = [
        'title',
        'description',
        'release_date',
        'rating',
        'poster_url',
    ];


    public function seasons(){
        return $this->hasMany(Season::class);
    }
}
