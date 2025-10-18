<?php

namespace App\Http\Controllers\Admin\Points;

use App\Http\Controllers\Controller;
use App\Models\PointsTransaction;
use App\Models\Kid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointsTransactionController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            $transactions = PointsTransaction::with('kid')->latest()->paginate(10);
        } elseif ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id');
            $transactions = PointsTransaction::with('kid')
                ->whereIn('kid_id', $kidsIds)
                ->latest()
                ->paginate(10);
        } elseif ($user->role->name === 'kid') {
            $transactions = PointsTransaction::with('kid')
                ->where('kid_id', $user->kid?->id)
                ->latest()
                ->paginate(10);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.Points.points-transactions.index', compact('transactions'));
    }

    public function show(PointsTransaction $pointsTransaction)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'parent' && !$user->children()->where('kids.id', $pointsTransaction->kid_id)->exists()) {
            abort(403, 'Unauthorized access.');
        }

        if ($user->role->name === 'kid' && $pointsTransaction->kid_id !== $user->kid?->id) {
            abort(403, 'Unauthorized access.');
        }

        $pointsTransaction->load('kid');
        return view('admin.Points.points-transactions.show', compact('pointsTransaction'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        $kids = Kid::all();
        return view('admin.Points.points-transactions.create', compact('kids'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

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

    public function edit(PointsTransaction $pointsTransaction)
    {
        $this->authorizeAdmin();

        $kids = Kid::all();
        return view('admin.Points.points-transactions.edit', compact('pointsTransaction', 'kids'));
    }

    public function update(Request $request, PointsTransaction $pointsTransaction)
    {
        $this->authorizeAdmin();

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

    public function destroy(PointsTransaction $pointsTransaction)
    {
        $this->authorizeAdmin();

        $pointsTransaction->delete();
        return redirect()->route('admin.points-transactions.index')->with('success', 'Transaction deleted successfully.');
    }

    private function authorizeAdmin()
    {
        $user = Auth::user();
        abort_unless($user && $user->role->name === 'admin', 403, 'Unauthorized action.');
    }
}
