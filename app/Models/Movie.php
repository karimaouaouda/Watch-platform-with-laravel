<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'description',
        'release_date',
        'rating',
        'poster_url',
        'url',
    ];


    public function generateSignedUrlForUser($user_id): string
    {
        return URL::temporarySignedRoute(
            'video.src',
            now()->addMinutes(2),
            ['user_id' => $user_id]
        );
    }
}
