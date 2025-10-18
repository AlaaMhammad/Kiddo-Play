<?php

namespace App\Http\Controllers\Admin\Kids;

use App\Http\Controllers\Controller;
use App\Models\Kid;
use App\Models\KidSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KidSessionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            $sessions = KidSession::with('kid')->latest()->paginate(10);
        } elseif (in_array($user->role->name, ['parent', 'kid'])) {
            $kidId = $user->kid?->id;
            $sessions = KidSession::with('kid')
                ->where('kid_id', $kidId)
                ->latest()
                ->paginate(10);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.kid-sessions.index', compact('sessions'));
    }

    public function show(KidSession $kidSession)
    {
        $user = Auth::user();
        $kidSession->load('kid');

        if ($user->role->name === 'admin') {
            return view('admin.kid-sessions.show', compact('kidSession'));
        }

        if (in_array($user->role->name, ['parent', 'kid'])) {
            $kidId = $user->kid?->id;
            abort_unless($kidSession->kid_id === $kidId, 403, 'You do not have access to this session.');
            return view('admin.kid-sessions.show', compact('kidSession'));
        }

        abort(403, 'Unauthorized');
    }

    // الأدمن فقط يستطيع إنشاء
    public function create()
    {
        $this->authorizeRole('admin');
        $kids = Kid::all()->map(fn($kid) => [
            'id' => $kid->id,
            'display_name' => $kid->display_name
        ])->toArray();

        return view('admin.kid-sessions.create', compact('kids'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole('admin');

        $validated = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'started_at' => 'nullable|date',
            'ended_at' => 'nullable|date|after_or_equal:started_at',
            'duration_seconds' => 'nullable|integer|min:0',
            'activity' => 'nullable|json',
        ]);

        KidSession::create($validated);

        return redirect()->route('admin.kid-sessions.index')
            ->with('success', 'Kid session created successfully.');
    }

    // الأدمن فقط يستطيع تعديل
    public function edit(KidSession $kidSession)
    {
        $this->authorizeRole('admin');

        $kids = Kid::all()->map(fn($kid) => [
            'id' => $kid->id,
            'display_name' => $kid->display_name
        ])->toArray();

        return view('admin.kid-sessions.edit', compact('kidSession', 'kids'));
    }

    public function update(Request $request, KidSession $kidSession)
    {
        $this->authorizeRole('admin');

        $validated = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'started_at' => 'nullable|date',
            'ended_at' => 'nullable|date|after_or_equal:started_at',
            'duration_seconds' => 'nullable|integer|min:0',
            'activity' => 'nullable|json',
        ]);

        $kidSession->update($validated);

        return redirect()->route('admin.kid-sessions.index')
            ->with('success', 'Kid session updated successfully.');
    }

    // الأدمن فقط يستطيع حذف
    public function destroy(KidSession $kidSession)
    {
        $this->authorizeRole('admin');

        $kidSession->delete();

        return redirect()->route('admin.kid-sessions.index')
            ->with('success', 'Kid session deleted successfully.');
    }

    // دالة مساعدة لفحص الدور
    private function authorizeRole($role)
    {
        $user = Auth::user();
        abort_unless($user && $user->role->name === $role, 403, 'Unauthorized action.');
    }
}
