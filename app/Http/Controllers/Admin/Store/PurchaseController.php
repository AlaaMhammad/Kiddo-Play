<?php

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Kid;
use App\Models\StoreItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            $purchases = Purchase::with(['kid', 'storeItem'])->latest()->paginate(10);
        } elseif ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id');
            $purchases = Purchase::whereIn('kid_id', $kidsIds)->with(['kid', 'storeItem'])->latest()->paginate(10);
        } elseif ($user->role->name === 'kid') {
            $purchases = Purchase::where('kid_id', $user->kid->id)->with(['kid', 'storeItem'])->latest()->paginate(10);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.Store.purchases.index', compact('purchases'));
    }

    public function show(Purchase $purchase)
    {
        $this->checkAccess($purchase);
        $purchase->load(['kid', 'storeItem']);
        return view('admin.Store.purchases.show', compact('purchase'));
    }

    public function create()
    {
        $this->authorizeRole('admin');
        $kids = Kid::all();
        $items = StoreItem::where('is_active', true)->get();
        return view('admin.Store.purchases.create', compact('kids', 'items'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole('admin');

        $validated = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'store_item_id' => 'required|exists:store_items,id',
            'points_used' => 'required|integer|min:0',
            'details' => 'nullable|string',
        ]);

        if (!empty($validated['details'])) {
            $validated['details'] = json_encode($validated['details']);
        }

        Purchase::create($validated);

        return redirect()->route('admin.purchases.index')->with('success', 'Purchase created successfully.');
    }

    public function edit(Purchase $purchase)
    {
        $this->authorizeRole('admin');
        $kids = Kid::all();
        $items = StoreItem::where('is_active', true)->get();
        return view('admin.Store.purchases.edit', compact('purchase', 'kids', 'items'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $this->authorizeRole('admin');

        $validated = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'store_item_id' => 'required|exists:store_items,id',
            'points_used' => 'required|integer|min:0',
            'details' => 'nullable|string',
        ]);

        if (!empty($validated['details'])) {
            $validated['details'] = json_encode($validated['details']);
        }

        $purchase->update($validated);

        return redirect()->route('admin.purchases.index')->with('success', 'Purchase updated successfully.');
    }

    public function destroy(Purchase $purchase)
    {
        $this->authorizeRole('admin');
        $purchase->delete();
        return redirect()->route('admin.purchases.index')->with('success', 'Purchase deleted successfully.');
    }

    private function checkAccess(Purchase $purchase)
    {
        /** @var User $user */

        $user = Auth::user();

        if ($user->role->name === 'admin') return;

        if ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id')->toArray();
            abort_unless(in_array($purchase->kid_id, $kidsIds), 403, 'Unauthorized access.');
        }

        if ($user->role->name === 'kid') {
            abort_unless($purchase->kid_id === $user->kid->id, 403, 'Unauthorized access.');
        }
    }

    private function authorizeRole($role)
    {
        /** @var User $user */
        $user = Auth::user();
        abort_unless($user && $user->role->name === $role, 403, 'Unauthorized action.');
    }
}
