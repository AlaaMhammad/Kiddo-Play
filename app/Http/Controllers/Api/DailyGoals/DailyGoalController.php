<?php

namespace App\Http\Controllers\Api\DailyGoals;

use App\Http\Controllers\Controller;
use App\Models\DailyGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyGoalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $goals = DailyGoal::where('kid_id', $user->id)
            ->whereDate('goal_date', now())
            ->get();

        return response()->json(['status' => 1, 'data' => $goals]);
    }

    public function complete($id)
    {
        $goal = DailyGoal::findOrFail($id);
        $goal->update(['is_completed' => true]);

        return response()->json([
            'status' => 1,
            'message' => 'Goal completed successfully!',
        ]);
    }
}
