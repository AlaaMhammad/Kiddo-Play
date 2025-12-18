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
        Schema::table('daily_goals', function (Blueprint $table) {
            $table->unsignedInteger('progress')->default(0)->after('target_points');
            $table->string('type')->nullable()->after('title'); // مثلا لتحديد نوع الهدف: game, word, quiz
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_goals', function (Blueprint $table) {
            $table->dropColumn('progress');
            $table->dropColumn('type');
        });
    }
};
