<?php

namespace App\Http\Controllers\Admin\Kids;

use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Models\Kid;
use App\Models\ParentChild;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class KidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kids = Kid::with(['user', 'avatar'])->latest()->paginate(10);
        return view('admin.kids.index', compact('kids'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // قائمة الآباء: id => name
        $parents = User::whereHas('role', fn($q) => $q->where('name', 'parent'))
            ->pluck('name', 'id');

        $avatars = Avatar::where('is_active', true)
            ->pluck('name', 'id');

        return view('admin.kids.create', compact('parents', 'avatars'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:users,id',
            'display_name' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'avatar_id' => 'nullable|exists:avatars,id',
            'points' => 'nullable|integer|min:0',
        ]);

        // إذا تم اختيار أب، استخدمه في user_id
        $userId = $validated['parent_id'] ?? null;

        $kid = Kid::create([
            'display_name' => $validated['display_name'] ?? null,
            'dob' => $validated['dob'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'avatar_id' => $validated['avatar_id'] ?? null,
            'points' => $validated['points'] ?? 0,
            'user_id' => $userId, // هذا هو التغيير المهم
        ]);

        // لو فيه أب إضافي غير user_id (علاقات Many-to-Many مع ParentChild)
        if (!empty($validated['parent_id'])) {
            $kid->parents()->attach($validated['parent_id']);
        }

        return redirect()->route('admin.kids.index')
            ->with('success', 'Kid created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kid $kid)
    {
        $kid->load([
            'avatar',
            'achievements.achievement',
            'lessonProgress.lesson',
            'sessions',
            'dailyGoals',
            'pointsTransactions',
            'parents', // من جدول parent_children
        ]);

        return view('admin.kids.show', compact('kid'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kid $kid)
    {
        // نحولها مباشرة إلى مصفوفة [id => name]
        $parents = User::whereHas('role', fn($q) => $q->where('name', 'parent'))
            ->pluck('name', 'id')->toArray();

        $avatars = Avatar::where('is_active', true)->pluck('name', 'id')->toArray();

        return view('admin.kids.edit', compact('kid', 'parents', 'avatars'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kid $kid)
    {
        $validated = $request->validate([
            'display_name' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'avatar_id' => 'nullable|exists:avatars,id',
            'points' => 'nullable|integer|min:0',
            'preferences' => 'nullable|json',
            'parent_id' => 'nullable|exists:users,id',
        ]);

        // تحديث العلاقة مع الأهل
        if (!empty($validated['parent_id'])) {
            // تحديث أو إنشاء العلاقة في جدول parent_children
            ParentChild::updateOrCreate(
                ['kid_id' => $kid->id],
                ['parent_id' => $validated['parent_id']]
            );

            // تحديث user_id في جدول kids ليكون نفس الأب (اختياري)
            $validated['user_id'] = $validated['parent_id'];
        }

        // لا ترسل parent_id إلى جدول kids لأنه غير موجود هناك
        $kid->update(collect($validated)->except('parent_id')->toArray());

        return redirect()
            ->route('admin.kids.index')
            ->with('success', 'Kid updated successfully and parent linked.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kid $kid)
    {
        // حذف العلاقات أولاً
        ParentChild::where('kid_id', $kid->id)->delete();
        $kid->delete();

        return redirect()
            ->route('admin.kids.index')
            ->with('success', 'Kid deleted successfully.');
    }
}
