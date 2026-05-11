<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            // baskan=Başkandan, yazi=Yazılar, duyuru=Duyurular
            $table->enum('category', ['baskan', 'yazi', 'duyuru'])->default('duyuru');
            // kktc, evkaf, manual
            $table->enum('source', ['kktc', 'evkaf', 'manual'])->default('manual');
            $table->string('external_id')->nullable();
            $table->string('title');
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('source_url')->nullable();
            $table->date('published_at')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->unique(['source', 'external_id']);
            $table->index(['category', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
