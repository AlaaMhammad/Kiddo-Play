<?php

namespace App\Http\Controllers\Admin\Notifications;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with('user')->latest()->paginate(10);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        $users = User::pluck('name', 'id');
        return view('admin.notifications.create', compact('users'));
    }

    public function store(Request $request)
    {
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

    public function show(Notification $notification)
    {
        return view('admin.notifications.show', compact('notification'));
    }

    public function edit(Notification $notification)
    {
        $users = User::pluck('name', 'id');
        return view('admin.notifications.edit', compact('notification', 'users'));
    }

    public function update(Request $request, Notification $notification)
    {
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
        $notification->delete();
        return back()->with('success', 'Notification deleted successfully!');
    }
}
