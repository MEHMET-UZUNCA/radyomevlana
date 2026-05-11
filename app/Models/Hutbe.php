<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hutbe extends Model
{
    protected $fillable = [
        'source_id', 'title', 'date', 'content',
        'pdf_url', 'word_url', 'source_url', 'is_manual', 'is_published',
    ];
    protected $casts = ['date' => 'date', 'is_manual' => 'boolean', 'is_published' => 'boolean'];
}
