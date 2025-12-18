<?php

namespace App\Services;

use App\Models\DailyGoal;
use App\Models\Kid;
use App\Models\Game;
use Carbon\Carbon;

class DailyGoalService
{
    /**
     * 📝 إنشاء Daily Goals لكل طفل تلقائيًا إذا لم توجد أهداف اليوم
     */
    public static function generateForToday()
    {
        $today = Carbon::today();

        $kids = Kid::all();
        $games = Game::where('is_active', true)->get();

        foreach ($kids as $kid) {
            // تحقق إذا كانت هناك أهداف اليوم
            $exists = DailyGoal::where('kid_id', $kid->id)
                ->whereDate('goal_date', $today)
                ->exists();

            if ($exists) continue;

            // مثال: هدف 1 - لعبة
            DailyGoal::create([
                'kid_id' => $kid->id,
                'game_id' => $games->random()?->id,
                'title' => 'Play a game',
                'description' => 'Play one game today',
                'target_points' => 10,
                'progress' => 0,
                'type' => 'game',
                'goal_date' => $today,
            ]);

            // هدف 2 - كلمة جديدة
            DailyGoal::create([
                'kid_id' => $kid->id,
                'title' => 'Learn a new word',
                'description' => 'Learn one new word today',
                'target_points' => 5,
                'progress' => 0,
                'type' => 'word',
                'goal_date' => $today,
            ]);

            // هدف 3 - اختبار
            DailyGoal::create([
                'kid_id' => $kid->id,
                'title' => 'Complete a quiz',
                'description' => 'Finish one quiz today',
                'target_points' => 15,
                'progress' => 0,
                'type' => 'quiz',
                'goal_date' => $today,
            ]);
        }
    }
}
