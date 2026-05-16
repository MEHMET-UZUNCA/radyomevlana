<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditorPost extends Model
{
    protected $fillable = ['title', 'excerpt', 'content', 'image', 'is_published', 'is_gunun_sozu', 'published_at'];
    protected $casts = ['is_published' => 'boolean', 'is_gunun_sozu' => 'boolean', 'published_at' => 'datetime'];
}
