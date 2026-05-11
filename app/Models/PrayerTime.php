<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrayerTime extends Model
{
    protected $fillable = ['date', 'imsak', 'fajr', 'sunrise', 'dhuhr', 'asr', 'maghrib', 'isha', 'is_manual'];
    protected $casts = ['date' => 'date', 'is_manual' => 'boolean'];

    public static function today(): ?self
    {
        return static::where('date', today()->toDateString())->first();
    }
}
