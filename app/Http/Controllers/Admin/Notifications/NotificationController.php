<?php

namespace App\Http\Controllers\Admin\Notifications;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * عرض قائمة الإشعارات
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $query = Notification::with('user')->latest();

        switch ($user->role->name) {
            case 'admin':
                // المسؤول يرى كل الإشعارات
                break;

            case 'parent':
                // الأب يرى إشعاراته وأطفاله
                $kidsIds = $user->children()->pluck('kids.id')->push($user->id);
                $query->whereIn('user_id', $kidsIds);
                break;

            case 'kid':
                // الطفل يرى إشعاراته فقط
                $query->where('user_id', $user->kid?->id);
                break;

            default:
                abort(403, 'Unauthorized');
        }

        $notifications = $query->paginate(10);

        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * عرض إشعار واحد
     */
    public function show(Notification $notification)
    {
        $this->authorizeView($notification);

        // تحديد الإشعار كمقروء عند العرض (تحسين UX)
        if (!$notification->is_read) {
            $notification->update(['is_read' => true]);
        }

        return view('admin.notifications.show', compact('notification'));
    }

    /**
     * إنشاء إشعار جديد
     */
    public function create()
    {
        $this->authorizeAdmin();
        $users = User::pluck('name', 'id');
        return view('admin.notifications.create', compact('users'));
    }

    /**
     * حفظ إشعار جديد
     */
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

        Notification::create($validated + [
            'sent_at' => $validated['sent_at'] ?? now(),
        ]);

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'Notification created successfully.');
    }

    /**
     * تعديل إشعار
     */
    public function edit(Notification $notification)
    {
        $this->authorizeAdmin();
        $users = User::pluck('name', 'id');
        return view('admin.notifications.edit', compact('notification', 'users'));
    }

    /**
     * تحديث إشعار
     */
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

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'Notification updated successfully.');
    }

    /**
     * حذف إشعار
     */
    public function destroy(Notification $notification)
    {
        $this->authorizeAdmin();
        $notification->delete();

        return back()->with('success', 'Notification deleted successfully.');
    }

    /**
     * وضع كل الإشعارات كمقروءة
     */
    public function markAllAsRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }


    public function dropdownNotifications()
    {
        /** @var User $user */
        $user = Auth::user();

        $query = Notification::with('user')->latest();

        switch ($user->role->name) {
            case 'admin':
                break;
            case 'parent':
                $kidsIds = $user->children()->pluck('kids.id')->push($user->id);
                $query->whereIn('user_id', $kidsIds);
                break;
            case 'kid':
                $query->where('user_id', $user->kid?->id);
                break;
            default:
                abort(403, 'Unauthorized');
        }

        $notifications = $query->take(5)->get(); // آخر 5 إشعارات فقط
        return $notifications;
    }


    /**
     * السماح فقط للمسؤول بالدخول
     */
    private function authorizeAdmin(): void
    {
        abort_unless(Auth::user()?->role?->name === 'admin', 403, 'Unauthorized action.');
    }

    /**
     * التحقق من صلاحية العرض
     */
    private function authorizeView(Notification $notification): void
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            return;
        }

        if ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id')->push($user->id)->toArray();
            abort_unless(in_array($notification->user_id, $kidsIds), 403, 'Unauthorized access.');
            return;
        }

        if ($user->role->name === 'kid') {
            abort_unless($notification->user_id === $user->kid?->id, 403, 'Unauthorized access.');
        }
    }
}
