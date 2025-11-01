<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Controller;
use App\Models\{StoreItem, Purchase, PointsTransaction};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function index()
    {
        $items = StoreItem::where('is_active', true)->get();
        return response()->json(['status' => 1, 'data' => $items]);
    }

    public function purchase($id)
    {
        $kid = Auth::user();
        $item = StoreItem::findOrFail($id);

        $balance = PointsTransaction::where('kid_id', $kid->id)->sum('amount');
        if ($balance < $item->cost_points) {
            return response()->json(['message' => 'Not enough points'], 400);
        }

        DB::transaction(function () use ($kid, $item) {
            Purchase::create([
                'kid_id' => $kid->id,
                'store_item_id' => $item->id,
                'points_used' => $item->cost_points,
                'details' => ['title' => $item->title],
            ]);

            PointsTransaction::create([
                'kid_id' => $kid->id,
                'type' => 'spend',
                'amount' => -$item->cost_points,
                'source' => 'store_purchase',
                'reference_id' => $item->id,
            ]);
        });

        return response()->json(['status' => 1, 'message' => 'Item purchased successfully!']);
    }
}
