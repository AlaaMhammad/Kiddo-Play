<?php

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Controller;
use App\Models\StoreItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreItemController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            $items = StoreItem::latest()->paginate(10);
        } else {
            // الوالد أو الطفل يرون فقط العناصر النشطة
            $items = StoreItem::where('is_active', true)->latest()->paginate(10);
        }

        return view('admin.Store.store-items.index', compact('items'));
    }

    public function show(StoreItem $store_item)
    {
        $this->checkAccess($store_item);
        return view('admin.Store.store-items.show', compact('store_item'));
    }

    public function create()
    {
        $this->authorizeRole('admin');
        return view('admin.Store.store-items.create');
    }

    public function store(Request $request)
    {
        $this->authorizeRole('admin');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost_points' => 'required|integer|min:0',
            'type' => 'nullable|string|max:100',
            'metadata' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if (!empty($validated['metadata'])) {
            $validated['metadata'] = json_encode($validated['metadata']);
        }

        StoreItem::create($validated);

        return redirect()->route('admin.store-items.index')
            ->with('success', 'Store item created successfully.');
    }

    public function edit(StoreItem $store_item)
    {
        $this->authorizeRole('admin');
        return view('admin.Store.store-items.edit', compact('store_item'));
    }

    public function update(Request $request, StoreItem $store_item)
    {
        $this->authorizeRole('admin');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost_points' => 'required|integer|min:0',
            'type' => 'nullable|string|max:100',
            'metadata' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if (!empty($validated['metadata'])) {
            $validated['metadata'] = json_encode($validated['metadata']);
        }

        $store_item->update($validated);

        return redirect()->route('admin.store-items.index')
            ->with('success', 'Store item updated successfully.');
    }

    public function destroy(StoreItem $store_item)
    {
        $this->authorizeRole('admin');
        $store_item->delete();

        return redirect()->route('admin.store-items.index')
            ->with('success', 'Store item deleted successfully.');
    }

    private function checkAccess(StoreItem $store_item)
    {
        $user = Auth::user();

        if ($user->role->name === 'admin') return;

        // الآباء والأطفال يمكنهم فقط رؤية العناصر النشطة
        abort_unless($store_item->is_active, 403, 'Unauthorized access');
    }

    private function authorizeRole($role)
    {
        $user = Auth::user();
        abort_unless($user && $user->role->name === $role, 403, 'Unauthorized action.');
    }
}
