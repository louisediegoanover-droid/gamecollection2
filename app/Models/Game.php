<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'title', 'genre', 'description', 'cover_image', 
        'rating', 'playtime', 'release_date', 'wishlist'
    ];

    protected $casts = [
        'release_date' => 'date',
        'rating' => 'decimal:1',
        'wishlist' => 'boolean'
    ];
}