<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Models\ParentalControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentalController extends Controller
{
    public function index()
    {
        $controls = ParentalControl::where('parent_id', Auth::id())->with('kid')->get();
        return response()->json(['status' => 1, 'data' => $controls]);
    }

    public function update(Request $request, $kidId)
    {
        $control = ParentalControl::where('parent_id', Auth::id())
            ->where('kid_id', $kidId)
            ->firstOrFail();

        $control->update($request->only([
            'daily_play_minutes_limit',
            'content_level',
            'purchases_enabled',
        ]));

        return response()->json(['status' => 1, 'message' => 'Parental control updated']);
    }
}
