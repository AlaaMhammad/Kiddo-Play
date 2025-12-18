<?php

namespace App\Http\Controllers\Api\DailyGoals;

use App\Http\Controllers\Controller;
use App\Models\DailyGoal;
use App\Models\User;
use App\Services\DailyGoalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyGoalController extends Controller
{

    public function index()
    {
        /**  @var User $user */
        $user = Auth::user();
        $today = now()->toDateString();

        DailyGoalService::generateForToday();

        if ($user->role->name === 'kid') {
            $kidId = $user->kid?->id;
            $goals = DailyGoal::where('kid_id', $kidId)
                ->whereDate('goal_date', $today)
                ->get();
        } elseif ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id');
            $goals = DailyGoal::whereIn('kid_id', $kidsIds)
                ->whereDate('goal_date', $today)
                ->get();
        } else {
            $goals = collect();
        }

        return response()->json(['status' => 1, 'data' => $goals]);
    }

    public function progress(Request $request, $id)
    {
        /**  @var User $user */
        $user = Auth::user();
        $goal = DailyGoal::findOrFail($id);

        // ✅ تحقق من أن المستخدم له حق الوصول (طفل أو والد أو أدمن)
        if ($user->role->name === 'kid' && $goal->kid_id !== $user->kid?->id) {
            abort(403, 'Unauthorized');
        }
        if ($user->role->name === 'parent' && !in_array($goal->kid_id, $user->children()->pluck('kids.id')->toArray())) {
            abort(403, 'Unauthorized');
        }

        if (!$goal->is_completed) {
            $goal->increment('progress');

            if ($goal->progress >= $goal->target_points) {
                $goal->is_completed = true;
                $goal->save();
            }
        }

        return response()->json([
            'status' => 1,
            'message' => 'Progress updated!',
            'data' => $goal
        ]);
    }

    public function complete($id)
    {
        /**  @var User $user */
        $user = Auth::user();
        $goal = DailyGoal::findOrFail($id);

        // ✅ تحقق من الوصول
        if ($user->role->name === 'kid' && $goal->kid_id !== $user->kid?->id) {
            abort(403, 'Unauthorized');
        }
        if ($user->role->name === 'parent' && !in_array($goal->kid_id, $user->children()->pluck('kids.id')->toArray())) {
            abort(403, 'Unauthorized');
        }

        $goal->update(['is_completed' => true]);

        return response()->json([
            'status' => 1,
            'message' => 'Goal completed successfully!',
        ]);
    }

    // public function index()
    // {
    //     $user = Auth::user();
    //     $today = now()->toDateString();

    //     // التحقق إذا الأهداف موجودة
    //     $goals = DailyGoal::where('kid_id', $user->id)
    //         ->whereDate('goal_date', $today)
    //         ->get();

    //     if ($goals->isEmpty()) {
    //         // إنشاء الأهداف اليومية تلقائيًا
    //         $goalsData = [
    //             [
    //                 'kid_id' => $user->id,
    //                 'title' => 'Play One Game',
    //                 'type' => 'game',
    //                 'target_points' => 1,
    //                 'progress' => 0,
    //                 'goal_date' => $today,
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ],
    //             [
    //                 'kid_id' => $user->id,
    //                 'title' => 'Learn New Word',
    //                 'type' => 'word',
    //                 'target_points' => 1,
    //                 'progress' => 0,
    //                 'goal_date' => $today,
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ],
    //             [
    //                 'kid_id' => $user->id,
    //                 'title' => 'Finish One Quiz',
    //                 'type' => 'quiz',
    //                 'target_points' => 1,
    //                 'progress' => 0,
    //                 'goal_date' => $today,
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ],
    //         ];

    //         DailyGoal::insert($goalsData);

    //         $goals = DailyGoal::where('kid_id', $user->id)
    //             ->whereDate('goal_date', $today)
    //             ->get();
    //     }

    //     return response()->json(['status' => 1, 'data' => $goals]);
    // }

    // public function progress(Request $request, $id)
    // {
    //     $goal = DailyGoal::findOrFail($id);

    //     if (!$goal->is_completed) {
    //         $goal->increment('progress');

    //         if ($goal->progress >= $goal->target_points) {
    //             $goal->is_completed = true;
    //             $goal->save();
    //         }
    //     }

    //     return response()->json([
    //         'status' => 1,
    //         'message' => 'Progress updated!',
    //         'data' => $goal
    //     ]);
    // }

    // public function complete($id)
    // {
    //     $goal = DailyGoal::findOrFail($id);
    //     $goal->update(['is_completed' => true]);

    //     return response()->json([
    //         'status' => 1,
    //         'message' => 'Goal completed successfully!',
    //     ]);
    // }
}
