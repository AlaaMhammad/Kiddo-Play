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
        Schema::create('parental_controls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kid_id')->constrained('kids')->onDelete('cascade');
            $table->unsignedInteger('daily_play_minutes_limit')->nullable();
            $table->enum('content_level', ['all', 'age_appropriate', 'restricted'])->default('age_appropriate');
            $table->boolean('purchases_enabled')->default(true);
            $table->json('rules')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parental_controls');
    }
};
