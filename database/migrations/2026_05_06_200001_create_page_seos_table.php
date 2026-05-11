<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('page_seos', function (Blueprint $table) {
            $table->id();
            $table->string('path')->unique(); // "/", "/hutbeler", "/editor" gibi
            $table->string('title')->nullable();
            $table->string('description', 320)->nullable();
            $table->string('keywords', 320)->nullable();
            $table->string('og_title')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_seos');
    }
};
