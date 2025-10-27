<?php

namespace App\Http\Controllers\Api\Settings;


use App\Http\Controllers\Controller;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        $settings = UserSetting::where('user_id', Auth::id())->first();
        return response()->json(['status' => 1, 'data' => $settings]);
    }

    public function update(Request $request)
    {
        $settings = UserSetting::updateOrCreate(
            ['user_id' => Auth::id()],
            $request->only(['sound_enabled', 'music_enabled', 'theme'])
        );

        return response()->json(['status' => 1, 'data' => $settings]);
    }
}
