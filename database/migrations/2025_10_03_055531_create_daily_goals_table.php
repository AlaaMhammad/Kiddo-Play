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
        Schema::create('daily_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kid_id')->constrained('kids')->onDelete('cascade');
            $table->foreignId('game_id')->nullable()->constrained('games')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('target_points')->default(0);
            $table->boolean('is_completed')->default(false);
            $table->date('goal_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_goals');
    }
};
