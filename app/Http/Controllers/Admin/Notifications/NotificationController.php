<?php

namespace App\Http\Controllers\Admin\Notifications;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            $notifications = Notification::with('user')->latest()->paginate(10);
        } elseif ($user->role->name === 'parent') {
            // الأب يرى إشعاراته وإشعارات أطفاله
            $kidsIds = $user->children()->pluck('kids.id');
            $notifications = Notification::whereIn('user_id', $kidsIds->push($user->id))
                ->with('user')
                ->latest()
                ->paginate(10);
        } elseif ($user->role->name === 'kid') {
            // الطفل يرى إشعاراته فقط
            $notifications = Notification::where('user_id', $user->kid?->id)
                ->with('user')
                ->latest()
                ->paginate(10);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.notifications.index', compact('notifications'));
    }

    public function show(Notification $notification)
    {
        $this->authorizeView($notification);
        return view('admin.notifications.show', compact('notification'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        $users = User::pluck('name', 'id');
        return view('admin.notifications.create', compact('users'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'is_read' => 'boolean',
            'payload' => 'nullable|array',
            'sent_at' => 'nullable|date',
        ]);

        Notification::create($validated);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification created successfully!');
    }

    public function edit(Notification $notification)
    {
        $this->authorizeAdmin();
        $users = User::pluck('name', 'id');
        return view('admin.notifications.edit', compact('notification', 'users'));
    }

    public function update(Request $request, Notification $notification)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'is_read' => 'boolean',
            'payload' => 'nullable|array',
            'sent_at' => 'nullable|date',
        ]);

        $notification->update($validated);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification updated successfully!');
    }

    public function destroy(Notification $notification)
    {
        $this->authorizeAdmin();
        $notification->delete();
        return back()->with('success', 'Notification deleted successfully!');
    }

    private function authorizeAdmin()
    {
        $user = Auth::user();
        abort_unless($user && $user->role->name === 'admin', 403, 'Unauthorized action.');
    }

    private function authorizeView(Notification $notification)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') return;

        if ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id');
            abort_unless(in_array($notification->user_id, $kidsIds->push($user->id)->toArray()), 403, 'Unauthorized access.');
        }

        if ($user->role->name === 'kid') {
            abort_unless($notification->user_id === $user->kid?->id, 403, 'Unauthorized access.');
        }
    }
}
