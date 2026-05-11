<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSeo extends Model
{
    protected $fillable = ['path', 'title', 'description', 'keywords', 'og_title', 'og_image'];

    public static function forPath(string $path): ?self
    {
        return static::where('path', $path)->first();
    }
}
