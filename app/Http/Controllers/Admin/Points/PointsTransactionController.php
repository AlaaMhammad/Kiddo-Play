<?php

namespace App\Http\Controllers\Admin\Points;

use App\Http\Controllers\Controller;
use App\Models\PointsTransaction;
use App\Models\Kid;
use Illuminate\Http\Request;

class PointsTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = PointsTransaction::with('kid')->latest()->paginate(10);
        return view('admin.Points.points-transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kids = Kid::all();
        return view('admin.Points.points-transactions.create', compact('kids'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'type' => 'required|in:earn,spend,adjust',
            'amount' => 'required|integer',
            'source' => 'nullable|string|max:255',
            'reference_id' => 'nullable|integer',
            'meta' => 'nullable|array',
        ]);

        PointsTransaction::create($validated);

        return redirect()->route('admin.points-transactions.index')->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PointsTransaction $pointsTransaction)
    {
        $pointsTransaction->load('kid');
        return view('admin.Points.points-transactions.show', compact('pointsTransaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PointsTransaction $pointsTransaction)
    {
        $kids = Kid::all();
        return view('admin.Points.points-transactions.edit', compact('pointsTransaction', 'kids'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PointsTransaction $pointsTransaction)
    {
        $validated = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'type' => 'required|in:earn,spend,adjust',
            'amount' => 'required|integer',
            'source' => 'nullable|string|max:255',
            'reference_id' => 'nullable|integer',
            'meta' => 'nullable|array',
        ]);

        $pointsTransaction->update($validated);

        return redirect()->route('admin.points-transactions.index')->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PointsTransaction $pointsTransaction)
    {
        $pointsTransaction->delete();
        return redirect()->route('admin.points-transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}
