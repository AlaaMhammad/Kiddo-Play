<?php

namespace App\Http\Controllers\Admin\Kids;

use App\Http\Controllers\Controller;
use App\Models\Kid;
use App\Models\KidSession;
use Illuminate\Http\Request;

class KidSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sessions = KidSession::with('kid')->latest()->paginate(10);
        return view('admin.kid-sessions.index', compact('sessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kids = Kid::all()->map(fn($kid) => [
            'id' => $kid->id,
            'display_name' => $kid->display_name
        ])->toArray();

        return view('admin.kid-sessions.create', compact('kids'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'started_at' => 'nullable|date',
            'ended_at' => 'nullable|date|after_or_equal:started_at',
            'duration_seconds' => 'nullable|integer|min:0',
            'activity' => 'nullable|json',
        ]);

        KidSession::create($validated);

        return redirect()->route('admin.kid-sessions.index')
            ->with('success', 'Kid session created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KidSession $kidSession)
    {
        // تحميل العلاقة مع الطفل (Kid)
        $kidSession->load('kid');

        return view('admin.kid-sessions.show', compact('kidSession'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KidSession $kidSession)
    {
        $kids = Kid::all()->map(fn($kid) => [
            'id' => $kid->id,
            'display_name' => $kid->display_name
        ])->toArray();

        return view('admin.kid-sessions.edit', compact('kidSession', 'kids'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KidSession $kidSession)
    {
        $validated = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'started_at' => 'nullable|date',
            'ended_at' => 'nullable|date|after_or_equal:started_at',
            'duration_seconds' => 'nullable|integer|min:0',
            'activity' => 'nullable|json',
        ]);

        $kidSession->update($validated);

        return redirect()->route('admin.kid-sessions.index')
            ->with('success', 'Kid session updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KidSession $kidSession)
    {
        $kidSession->delete();

        return redirect()->route('admin.kid-sessions.index')
            ->with('success', 'Kid session deleted successfully.');
    }
}
