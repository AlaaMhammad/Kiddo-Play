<?php

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Controller;
use App\Models\StoreItem;
use Illuminate\Http\Request;

class StoreItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = StoreItem::latest()->paginate(10);
        return view('admin.Store.store-items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Store.store-items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost_points' => 'required|integer|min:0',
            'type' => 'nullable|string|max:100',
            'metadata' => 'nullable|json',
            'is_active' => 'boolean',
        ]);

        StoreItem::create($validated);

        return redirect()->route('admin.Store.store-items.index')
            ->with('success', 'Store item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StoreItem $store_item)
    {
        return view('admin.Store.store-items.show', compact('store_item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StoreItem $store_item)
    {
        return view('admin.Store.store-items.edit', compact('store_item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StoreItem $store_item)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost_points' => 'required|integer|min:0',
            'type' => 'nullable|string|max:100',
            'metadata' => 'nullable|json',
            'is_active' => 'boolean',
        ]);

        $store_item->update($validated);

        return redirect()->route('admin.Store.store-items.index')
            ->with('success', 'Store item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StoreItem $store_item)
    {
        $store_item->delete();

        return redirect()->route('admin.Store.store-items.index')
            ->with('success', 'Store item deleted successfully.');
    }
}
