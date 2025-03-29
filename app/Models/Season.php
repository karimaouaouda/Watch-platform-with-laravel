<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Season extends Model
{
    protected $fillable = [
        'title',
        'series_id',
        'season_number',
        'release_date',
        'description'
    ];


    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    // attributes
    public function getDirectoryAttribute(){
        return sprintf(
            "series_%s/season_%s/episodes",
            $this->series()->first()->id,
            $this->id,
        );
    }
}
