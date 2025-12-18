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
        Schema::table('games', function (Blueprint $table) {
            $table->string('title')->after('id');
            $table->string('game_url')->after('media_url');
            $table->unsignedInteger('required_points')->default(0)->after('game_url');
            $table->unsignedInteger('entry_cost')->default(0)->after('required_points');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'game_url',
                'required_points',
                'entry_cost',
            ]);
        });
    }
};
