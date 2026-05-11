<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = ['title', 'slug', 'excerpt', 'content', 'meta_description', 'is_published'];
    protected $casts    = ['is_published' => 'boolean'];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (self $page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    public function getUrlAttribute(): string
    {
        return route('page.show', $this->slug);
    }
}
