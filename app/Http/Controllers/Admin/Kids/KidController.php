<?php

namespace App\Http\Controllers\Admin\Kids;

use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Models\Kid;
use App\Models\ParentChild;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class KidController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            $kids = Kid::with(['parents', 'user', 'avatar'])->latest()->paginate(10);
        } elseif ($user->role->name === 'parent') {
            $kids = $user->children()->with(['parents', 'user', 'avatar'])->paginate(10);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.kids.index', compact('kids'));
    }

    /**
     * إظهار نموذج إنشاء طفل جديد.
     */
    public function create()
    {
        $this->authorize('create', Kid::class);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->role->name === 'parent') {
            // الأب الحالي هو الـ parentId، لا نعرض قائمة اختيار
            $parentId = $user->id;
            $parents = null;
        } else {
            // الأدمن يرى قائمة الآباء
            $parents = User::whereHas('role', fn($q) => $q->where('name', 'parent'))
                ->pluck('name', 'id');
            $parentId = null;
        }

        $avatars = Avatar::where('is_active', true)->pluck('name', 'id');

        return view('admin.kids.create', compact('parents', 'avatars', 'parentId'));
    }

    /**
     * تخزين الطفل وحسابه.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Kid::class);

        $validated = $request->validate([
            'display_name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'avatar_id' => 'nullable|exists:avatars,id',
            'points' => 'nullable|integer|min:0',
            'parent_id' => 'nullable|exists:users,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        // إنشاء حساب الطفل
        $kidUser = User::create([
            'name' => $validated['display_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'plain_password' => $validated['password'],
            'role_id' => DB::table('roles')->where('name', 'kid')->value('id'),
        ]);

        // إنشاء سجل الطفل
        $kid = Kid::create([
            'display_name' => $validated['display_name'],
            'dob' => $validated['dob'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'avatar_id' => $validated['avatar_id'] ?? null,
            'points' => $validated['points'] ?? 0,
            'user_id' => $kidUser->id, // رابط لحساب الطفل نفسه
        ]);

        // ربط الطفل بالوالد (علاقة Many-to-Many)
        if (!empty($validated['parent_id'])) {
            $kid->parents()->attach($validated['parent_id']);
        }

        flash()->success('Kid and account created successfully!');
        return redirect()->route('admin.kids.index');
    }

    /**
     * عرض تفاصيل الطفل.
     */
    public function show(Kid $kid)
    {
        $this->authorize('create', $kid);
        $kid->load(['avatar', 'parents', 'user']);
        return view('admin.kids.show', compact('kid'));
    }

    /**
     * إظهار نموذج تعديل الطفل.
     */
    public function edit(Kid $kid)
    {
        $this->authorize('update', $kid);

        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'parent') {
            // الأب الحالي مرتبط بالطفل
            $parentId = $user->id;
            $parents = null; // لا نعرض قائمة اختيار الأب
        } else {
            // الأدمن يرى قائمة اختيار الأب
            $parents = User::whereHas('role', fn($q) => $q->where('name', 'parent'))
                ->pluck('name', 'id');
            $parentId = null; // الأب غير معروف بشكل مباشر
        }

        $avatars = Avatar::where('is_active', true)->pluck('name', 'id');

        return view('admin.kids.edit', compact('kid', 'parents', 'avatars', 'parentId'));
    }


    /**
     * تحديث الطفل وحسابه.
     */
    public function update(Request $request, Kid $kid)
    {
        $this->authorize('update', $kid);
        $validated = $request->validate([
            'display_name' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'avatar_id' => 'nullable|exists:avatars,id',
            'points' => 'nullable|integer|min:0',
            'preferences' => 'nullable|json',
            'parent_id' => 'nullable|exists:users,id',
            'email' => 'nullable|email|unique:users,email,' . $kid->user_id,
            'password' => 'nullable|confirmed|min:6',
        ]);

        // تحديث بيانات الطفل (بدون email و password)
        $kid->update(collect($validated)->except(['parent_id', 'email', 'password'])->toArray());

        // تحديث حساب الطفل
        if ($kid->user) {
            $kid->user->update([
                'name' => $validated['display_name'] ?? $kid->user->name,
                'email' => $validated['email'] ?? $kid->user->email,
                'password' => !empty($validated['password']) ? Hash::make($validated['password']) : $kid->user->password,
                'plain_password' => !empty($validated['password']) ? $validated['password'] : $kid->user->plain_password,
            ]);
        }

        // تحديث علاقة الأب فقط
        if (!empty($validated['parent_id'])) {
            $kid->parents()->sync([$validated['parent_id']]); // يربط الأب الجديد فقط
        }

        flash()->success('Kid and account updated successfully!');
        return redirect()->route('admin.kids.index');
    }

    /**
     * حذف الطفل وحسابه فقط.
     */
    public function destroy(Kid $kid)
    {
        $this->authorize('delete', $kid);

        // فصل علاقات الأب
        $kid->parents()->detach();

        // حذف حساب الطفل
        if ($kid->user) {
            $kid->user->delete();
        }

        // حذف سجل الطفل
        $kid->delete();

        flash()->success('Kid and account deleted successfully!');
        return redirect()->route('admin.kids.index');
    }


    public function showKidAuth(Kid $kid)
    {
        $user = $kid->user;
        if (!$user) {
            return response()->json(['error' => 'No user linked to this kid.'], 404);
        }

        return response()->json([
            'success' => true,
            'kid_name' => $kid->display_name,
            'email' => $user->email,
            'password' => $user->plain_password ?? 'N/A', // كلمة المرور المخزنة مؤقتًا
        ]);
    }
}
