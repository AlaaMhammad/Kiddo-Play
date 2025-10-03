<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->enum('category', ['educational', 'fun', 'mixed'])->default('educational');
            $table->enum('difficulty_level', ['easy', 'medium', 'hard'])->default('easy');
            $table->string('media_url')->nullable(); // صورة أو فيديو للعبة
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
