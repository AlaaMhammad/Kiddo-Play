<?php

namespace App\Jobs;
use App\Models\DailyGoal;
use App\Models\Kid;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;


class GenerateDailyGoals implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $today = Carbon::today();

        foreach (Kid::all() as $kid) {
            // نتأكد أن الأهداف لهذا اليوم لم تُنشأ بعد
            $existingGoals = DailyGoal::where('kid_id', $kid->id)
                ->whereDate('goal_date', $today)
                ->exists();

            if ($existingGoals) continue;

            DailyGoal::insert([
                [
                    'kid_id' => $kid->id,
                    'title' => 'Play One Game',
                    'type' => 'game',
                    'target_points' => 1,
                    'progress' => 0,
                    'goal_date' => $today,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'kid_id' => $kid->id,
                    'title' => 'Learn New Word',
                    'type' => 'word',
                    'target_points' => 1,
                    'progress' => 0,
                    'goal_date' => $today,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'kid_id' => $kid->id,
                    'title' => 'Finish One Quiz',
                    'type' => 'quiz',
                    'target_points' => 1,
                    'progress' => 0,
                    'goal_date' => $today,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
