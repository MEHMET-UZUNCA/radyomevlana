<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'category', 'source', 'external_id', 'title', 'excerpt',
        'content', 'source_url', 'published_at', 'is_published',
    ];
    protected $casts = ['published_at' => 'date', 'is_published' => 'boolean'];
}
