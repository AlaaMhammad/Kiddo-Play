<?php

namespace App\Http\Controllers\Api\Points;

use App\Http\Controllers\Controller;
use App\Models\PointsTransaction;
use Illuminate\Support\Facades\Auth;

class PointsController extends Controller
{
    public function index()
    {
        $kid = Auth::user();
        $transactions = PointsTransaction::where('kid_id', $kid->id)
            ->latest()
            ->get();

        $balance = PointsTransaction::where('kid_id', $kid->id)->sum('amount');

        return response()->json([
            'status' => 1,
            'balance' => $balance,
            'transactions' => $transactions
        ]);
    }
}
