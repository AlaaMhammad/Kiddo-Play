<?php

namespace App\Http\Controllers\Api\Rewards;

use App\Http\Controllers\Controller;
use App\Models\{Reward, PointsTransaction};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::with('dailyGoal')->get();
        return response()->json(['status' => 1, 'data' => $rewards]);
    }

    public function claim($id)
    {
        $reward = Reward::findOrFail($id);
        $kid = Auth::user();

        if ($reward->is_claimed) {
            return response()->json(['message' => 'Already claimed'], 400);
        }

        // deduct points if necessary
        $data = PointsTransaction::create([
            'kid_id' => $kid->id,
            'type' => 'spend',
            'amount' => $reward->points_required,
            'source' => 'reward_claim',
            'reference_id' => $reward->id,
        ]);

        $reward->update([
            'is_claimed' => true,
            'claimed_at' => now(),
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Reward claimed successfully!',
            'data' => $data,
        ]);
    }
}
