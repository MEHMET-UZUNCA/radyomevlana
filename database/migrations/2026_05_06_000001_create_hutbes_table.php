<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hutbes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('source_id')->nullable()->unique();
            $table->string('title');
            $table->date('date');
            $table->longText('content')->nullable();
            $table->string('pdf_url')->nullable();
            $table->string('word_url')->nullable();
            $table->string('source_url')->nullable();
            $table->boolean('is_manual')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hutbes');
    }
};
