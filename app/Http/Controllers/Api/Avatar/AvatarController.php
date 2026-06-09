<?php

namespace App\Http\Controllers\Api\Avatar;

use App\Http\Controllers\Controller;
use App\Models\Avatar;
use Illuminate\Support\Facades\Auth;

class AvatarController extends Controller
{
    /**
     *  Get Avatar Shop (active avatars only)
     */
    public function index()
    {
        $kid = Auth::user()->kid;

        $avatars = Avatar::where('is_active', true)
            ->latest()
            ->get()
            ->map(function ($avatar) use ($kid) {

                return [
                    'id' => $avatar->id,
                    'name' => $avatar->name,
                    'image_url' => asset('storage/' . $avatar->image_url),
                    'cost_points' => $avatar->cost_points,
                    'is_owned' => $kid
                        ? $kid->avatars()->where('avatar_id', $avatar->id)->exists()
                        : false,
                    'is_selected' => $kid
                        ? (int)$kid->avatar_id === $avatar->id
                        : false,
                ];
            });

        return response()->json([
            'message' => 'Avatar shop loaded successfully',
            'data' => $avatars
        ]);
    }

    /**
     *  Owned avatars
     */
    public function owned()
    {
        $kid = Auth::user()?->kid;

        // ❌ لا ترجع error أبداً
        if (!$kid) {
            return response()->json([
                'data' => [
                    [
                        'id' => 0,
                        'name' => 'Default Avatar',
                        'image_url' => asset('storage/' . 'avatars/NxNiPSbpXrTRl1Tg1m9OZetv0p4btIMPqhJJb831.png'),
                        'is_default' => true,
                        'is_selected' => true,
                    ]
                ]
            ]);
        }

        return response()->json([
            'data' => $kid->avatars->map(function ($avatar) use ($kid) {
                return [
                    'id' => $avatar->id,
                    'name' => $avatar->name,
                    'image_url' => asset('storage/' . $avatar->image_url),
                    'is_selected' => (int)$kid->avatar_id === $avatar->id,
                ];
            })
        ]);
    }

    /**
     *  Buy avatar
     */
    public function buy(Avatar $avatar)
    {
        $kid = Auth::user()->kid;

        if (!$kid) {
            return response()->json(['message' => 'Only kids can buy avatars'], 403);
        }

        if (!$avatar->is_active) {
            return response()->json(['message' => 'Avatar not available'], 400);
        }

        // already owned
        if ($kid->avatars()->where('avatar_id', $avatar->id)->exists()) {
            return response()->json(['message' => 'Already owned'], 409);
        }

        // check points
        if ($kid->points < $avatar->cost_points) {
            return response()->json(['message' => 'Not enough points'], 400);
        }

        // spend points
        $kid->spendPoints(
            $avatar->cost_points,
            'avatar_purchase',
            $avatar->id
        );

        // attach ownership
        $kid->avatars()->attach($avatar->id);

        // auto select
        $kid->update([
            'avatar_id' => $avatar->id
        ]);

        return response()->json([
            'message' => 'Avatar purchased successfully',
            'data' => [
                'avatar_id' => $avatar->id
            ]
        ]);
    }

    /**
     *  Select avatar (must be owned)
     */
    public function select(Avatar $avatar)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $kid = $user->kid;

        if (!$kid) {
            return response()->json([
                'message' => 'This user has no kid profile attached'
            ], 404);
        }

        $owned = $kid->avatars()->where('avatar_id', $avatar->id)->exists();

        if (!$owned) {
            return response()->json([
                'message' => 'You must buy this avatar first'
            ], 403);
        }

        $kid->update([
            'avatar_id' => $avatar->id
        ]);

        return response()->json([
            'message' => 'Avatar selected successfully',
            'selected_avatar_id' => $avatar->id
        ]);
    }
}
