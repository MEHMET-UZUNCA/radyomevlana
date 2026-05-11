<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SongHistory extends Model
{
    protected $table = 'song_history';
    protected $fillable = ['title', 'artist', 'album_art', 'played_at'];
    protected $casts = ['played_at' => 'datetime'];
}
