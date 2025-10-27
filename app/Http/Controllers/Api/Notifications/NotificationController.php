<?php

namespace App\Http\Controllers\Api\Notifications;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->get();

        return response()->json(['status' => 1, 'data' => $notifications]);
    }

    public function markAsRead()
    {
        $user = Auth::user();
        Notification::where('user_id', $user->id)
            ->update(['is_read' => true]);

        return response()->json(['status' => 1, 'message' => 'All notifications marked as read']);
    }
}
