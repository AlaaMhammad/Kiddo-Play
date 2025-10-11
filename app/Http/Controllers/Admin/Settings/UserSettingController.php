<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\UserSetting;
use App\Models\User;
use Illuminate\Http\Request;

class UserSettingController extends Controller
{
    public function index()
    {
        $settings = UserSetting::with('user')->latest()->paginate(10);
        return view('admin.Settings.user-settings.index', compact('settings'));
    }

    public function create()
    {
        $users = User::pluck('name', 'id');
        return view('admin.Settings.user-settings.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'sound_enabled' => 'boolean',
            'music_enabled' => 'boolean',
            'theme' => 'required|string|max:50',
            'extra' => 'nullable|array',
        ]);

        UserSetting::create($validated);

        return redirect()->route('admin.user-settings.index')
            ->with('success', 'User setting created successfully!');
    }

    public function show(UserSetting $userSetting)
    {
        return view('admin.Settings.user-settings.show', compact('userSetting'));
    }

    public function edit(UserSetting $userSetting)
    {
        $users = User::pluck('name', 'id');
        return view('admin.Settings.user-settings.edit', compact('userSetting', 'users'));
    }

    public function update(Request $request, UserSetting $userSetting)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'sound_enabled' => 'boolean',
            'music_enabled' => 'boolean',
            'theme' => 'required|string|max:50',
            'extra' => 'nullable|array',
        ]);

        $userSetting->update($validated);

        return redirect()->route('admin.user-settings.index')
            ->with('success', 'User setting updated successfully!');
    }

    public function destroy(UserSetting $userSetting)
    {
        $userSetting->delete();
        return back()->with('success', 'User setting deleted successfully!');
    }
}
