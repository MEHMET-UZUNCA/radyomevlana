<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('song_history', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('artist')->nullable();
            $table->string('album_art')->nullable();
            $table->timestamp('played_at');
            $table->timestamps();

            $table->index('played_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('song_history');
    }
};
