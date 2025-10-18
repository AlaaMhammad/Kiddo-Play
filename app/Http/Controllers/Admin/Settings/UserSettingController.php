<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\UserSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSettingController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            $settings = UserSetting::with('user')->latest()->paginate(10);
        } elseif ($user->role->name === 'parent') {
            // الأب يرى إعداداته وإعدادات أطفاله
            $kidsIds = $user->children()->pluck('kids.id');
            $settings = UserSetting::whereIn('user_id', $kidsIds->push($user->id))
                ->with('user')
                ->latest()
                ->paginate(10);
        } elseif ($user->role->name === 'kid') {
            // الطفل يرى إعداداته فقط
            $settings = UserSetting::where('user_id', $user->kid?->id)
                ->with('user')
                ->latest()
                ->paginate(10);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.Settings.user-settings.index', compact('settings'));
    }

    public function show(UserSetting $userSetting)
    {
        $this->authorizeView($userSetting);
        return view('admin.Settings.user-settings.show', compact('userSetting'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        $users = User::pluck('name', 'id');
        return view('admin.Settings.user-settings.create', compact('users'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

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

    public function edit(UserSetting $userSetting)
    {
        $this->authorizeAdmin();
        $users = User::pluck('name', 'id');
        return view('admin.Settings.user-settings.edit', compact('userSetting', 'users'));
    }

    public function update(Request $request, UserSetting $userSetting)
    {
        $this->authorizeAdmin();

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
        $this->authorizeAdmin();
        $userSetting->delete();
        return back()->with('success', 'User setting deleted successfully!');
    }

    private function authorizeAdmin()
    {
        $user = Auth::user();
        abort_unless($user && $user->role->name === 'admin', 403, 'Unauthorized action.');
    }

    private function authorizeView(UserSetting $userSetting)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') return;

        if ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id');
            abort_unless(in_array($userSetting->user_id, $kidsIds->push($user->id)->toArray()), 403, 'Unauthorized access.');
        }

        if ($user->role->name === 'kid') {
            abort_unless($userSetting->user_id === $user->kid?->id, 403, 'Unauthorized access.');
        }
    }
}
