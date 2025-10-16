<?php

namespace App\Http\Controllers\Admin\Kids;

use App\Http\Controllers\Controller;
use App\Models\ParentChild;
use App\Models\User;
use App\Models\Kid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentChildController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            // Admin يشوف كل الآباء والأطفال المرتبطين
            $parentChildren = ParentChild::with(['parent', 'kid'])->latest()->paginate(10);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.parent-children.index', compact('parentChildren'));
    }

    public function create()
    {
        // جلب الآباء فقط عبر العلاقة role
        $parents = User::whereHas('role', function ($q) {
            $q->where('name', 'parent');
        })->pluck('name', 'id');

        $kids = Kid::pluck('display_name', 'id');

        // لو مافيه بيانات، نرجع تنبيه جميل بدل الخطأ
        if ($parents->isEmpty() || $kids->isEmpty()) {
            return redirect()->route('admin.parent-children.index')
                ->with('warning', 'Please make sure there are both Parents and Kids before linking.');
        }

        return view('admin.parent-children.create', compact('parents', 'kids'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'parent_id' => 'required|exists:users,id',
            'kid_id'    => 'required|exists:kids,id',
        ]);

        ParentChild::create($data);

        return redirect()->route('admin.parent-children.index')->with('success', 'Relation added successfully');
    }

    public function show(ParentChild $parentChild)
    {
        $parentChild->load(['parent', 'kid']);
        return view('admin.parent-children.show', compact('parentChild'));
    }

    public function edit(ParentChild $parentChild)
    {
        $parents = User::whereHas('role', function ($q) {
            $q->where('name', 'parent');
        })->pluck('name', 'id');

        $kids = Kid::pluck('display_name', 'id');

        return view('admin.parent-children.edit', compact('parentChild', 'parents', 'kids'));
    }

    public function update(Request $request, ParentChild $parentChild)
    {
        $data = $request->validate([
            'parent_id' => 'required|exists:users,id',
            'kid_id'    => 'required|exists:kids,id',
        ]);

        $parentChild->update($data);

        return redirect()->route('admin.parent-children.index')->with('success', 'Relation updated successfully');
    }

    public function destroy(ParentChild $parentChild)
    {
        $parentChild->delete();
        return redirect()->route('admin.parent-children.index')->with('success', 'Relation deleted successfully');
    }
}
