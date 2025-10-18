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
    private function authorizeRole($role)
    {
        /** @var User $user */
        $user = Auth::user();
        abort_unless($user && $user->role->name === $role, 403, 'Unauthorized action.');
    }

    public function index()
    {
        $this->authorizeRole('admin');

        $parentChildren = ParentChild::with(['parent', 'kid'])->latest()->paginate(10);
        return view('admin.parent-children.index', compact('parentChildren'));
    }

    public function create()
    {
        $this->authorizeRole('admin');

        $parents = User::whereHas('role', fn($q) => $q->where('name', 'parent'))->pluck('name', 'id');
        $kids = Kid::pluck('display_name', 'id');

        if ($parents->isEmpty() || $kids->isEmpty()) {
            return redirect()->route('admin.parent-children.index')
                ->with('warning', 'Please make sure there are both Parents and Kids before linking.');
        }

        return view('admin.parent-children.create', compact('parents', 'kids'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole('admin');

        $data = $request->validate([
            'parent_id' => 'required|exists:users,id',
            'kid_id'    => 'required|exists:kids,id',
        ]);

        ParentChild::create($data);

        return redirect()->route('admin.parent-children.index')->with('success', 'Relation added successfully');
    }

    public function show(ParentChild $parentChild)
    {
        $this->authorizeRole('admin');

        $parentChild->load(['parent', 'kid']);
        return view('admin.parent-children.show', compact('parentChild'));
    }

    public function edit(ParentChild $parentChild)
    {
        $this->authorizeRole('admin');

        $parents = User::whereHas('role', fn($q) => $q->where('name', 'parent'))->pluck('name', 'id');
        $kids = Kid::pluck('display_name', 'id');

        return view('admin.parent-children.edit', compact('parentChild', 'parents', 'kids'));
    }

    public function update(Request $request, ParentChild $parentChild)
    {
        $this->authorizeRole('admin');

        $data = $request->validate([
            'parent_id' => 'required|exists:users,id',
            'kid_id'    => 'required|exists:kids,id',
        ]);

        $parentChild->update($data);

        return redirect()->route('admin.parent-children.index')->with('success', 'Relation updated successfully');
    }

    public function destroy(ParentChild $parentChild)
    {
        $this->authorizeRole('admin');

        $parentChild->delete();
        return redirect()->route('admin.parent-children.index')->with('success', 'Relation deleted successfully');
    }
}
