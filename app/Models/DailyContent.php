<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyContent extends Model
{
    protected $fillable = ['type', 'title', 'content_ar', 'content_tr', 'source', 'date', 'is_manual', 'is_published'];
    protected $casts = ['date' => 'date', 'is_manual' => 'boolean', 'is_published' => 'boolean'];

    public static function todayOf(string $type): ?self
    {
        return static::where('type', $type)
            ->where('date', today()->toDateString())
            ->where('is_published', true)
            ->latest()
            ->first();
    }
}
