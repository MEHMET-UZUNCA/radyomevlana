<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SongRequest extends Model
{
    protected $fillable = ['name', 'phone', 'city', 'song_title', 'artist', 'message', 'status', 'played_at'];
    protected $casts = ['played_at' => 'datetime'];
}
