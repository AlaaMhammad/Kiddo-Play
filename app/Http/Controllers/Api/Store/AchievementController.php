<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Controller;
use App\Models\{Achievement, KidAchievement};
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    /**
     * عرض جميع الإنجازات (التي حصل عليها الطفل والتي لم يحصل عليها بعد)
     */
    public function index()
    {
        $kid = Auth::user();

        $all = Achievement::all();
        $owned = KidAchievement::where('kid_id', $kid->id)->pluck('achievement_id')->toArray();

        $data = $all->map(function ($ach) use ($owned) {
            return [
                'id' => $ach->id,
                'title' => $ach->title,
                'description' => $ach->description,
                'points_award' => $ach->points_award,
                'icon_url' => $ach->icon_url,
                'earned' => in_array($ach->id, $owned),
            ];
        });

        return response()->json(['status' => 1, 'data' => $data]);
    }

    /**
     * عرض الإنجازات التي حصل عليها الطفل فقط
     */
    public function myAchievements()
    {
        $kid = Auth::user();

        $achievements = KidAchievement::with('achievement')
            ->where('kid_id', $kid->id)
            ->get()
            ->map(fn($a) => [
                'title' => $a->achievement->title,
                'description' => $a->achievement->description,
                'icon_url' => $a->achievement->icon_url,
                'awarded_at' => $a->awarded_at,
            ]);

        return response()->json(['status' => 1, 'data' => $achievements]);
    }
}
