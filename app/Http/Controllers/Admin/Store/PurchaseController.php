<?php

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Kid;
use App\Models\StoreItem;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with(['kid', 'storeItem'])->latest()->paginate(10);
        return view('admin.Store.purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kids = Kid::all();
        $items = StoreItem::where('is_active', true)->get();

        return view('admin.Store.purchases.create', compact('kids', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'store_item_id' => 'required|exists:store_items,id',
            'points_used' => 'required|integer|min:0',
            'details' => 'nullable|json',
        ]);

        Purchase::create($validated);

        return redirect()->route('admin.Store.purchases.index')->with('success', 'Purchase created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        $purchase->load(['kid', 'storeItem']);
        return view('admin.Store.purchases.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        $kids = Kid::all();
        $items = StoreItem::where('is_active', true)->get();

        return view('admin.Store.purchases.edit', compact('purchase', 'kids', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'store_item_id' => 'required|exists:store_items,id',
            'points_used' => 'required|integer|min:0',
            'details' => 'nullable|json',
        ]);

        $purchase->update($validated);

        return redirect()->route('admin.Store.purchases.index')->with('success', 'Purchase updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('admin.Store.purchases.index')->with('success', 'Purchase deleted successfully.');
    }
}
