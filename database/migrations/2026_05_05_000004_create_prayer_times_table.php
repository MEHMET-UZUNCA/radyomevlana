<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prayer_times', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->string('imsak', 5);
            $table->string('fajr', 5);
            $table->string('sunrise', 5);
            $table->string('dhuhr', 5);
            $table->string('asr', 5);
            $table->string('maghrib', 5);
            $table->string('isha', 5);
            $table->boolean('is_manual')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prayer_times');
    }
};
