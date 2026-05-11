<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('daily_contents', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['ayet', 'hadis', 'soz']);
            $table->string('title')->nullable();
            $table->text('content_ar')->nullable();
            $table->text('content_tr');
            $table->string('source')->nullable();
            $table->date('date');
            $table->boolean('is_manual')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index(['type', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_contents');
    }
};
