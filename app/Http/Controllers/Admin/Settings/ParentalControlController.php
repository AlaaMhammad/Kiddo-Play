<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\ParentalControl;
use App\Models\User;
use App\Models\Kid;
use Illuminate\Http\Request;

class ParentalControlController extends Controller
{
    public function index()
    {
        $controls = ParentalControl::with(['parent', 'kid'])->latest()->paginate(10);
        return view('admin.Settings.parental-controls.index', compact('controls'));
    }

    public function create()
    {
        $parents = User::pluck('name', 'id');
        $kids = Kid::pluck('display_name', 'id');
        return view('admin.Settings.parental-controls.create', compact('parents', 'kids'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_id' => 'required|exists:users,id',
            'kid_id' => 'required|exists:kids,id',
            'daily_play_minutes_limit' => 'nullable|integer|min:0',
            'content_level' => 'required|in:all,age_appropriate,restricted',
            'purchases_enabled' => 'boolean',
            'rules' => 'nullable|array',
        ]);

        ParentalControl::create($validated);

        return redirect()->route('admin.parental-controls.index')
            ->with('success', 'Parental control created successfully!');
    }

    public function show(ParentalControl $parentalControl)
    {
        return view('admin.Settings.parental-controls.show', compact('parentalControl'));
    }

    public function edit(ParentalControl $parentalControl)
    {
        $parents = User::pluck('name', 'id');
        $kids = Kid::pluck('display_name', 'id');
        return view('admin.Settings.parental-controls.edit', compact('parentalControl', 'parents', 'kids'));
    }

    public function update(Request $request, ParentalControl $parentalControl)
    {
        $validated = $request->validate([
            'parent_id' => 'required|exists:users,id',
            'kid_id' => 'required|exists:kids,id',
            'daily_play_minutes_limit' => 'nullable|integer|min:0',
            'content_level' => 'required|in:all,age_appropriate,restricted',
            'purchases_enabled' => 'boolean',
            'rules' => 'nullable|array',
        ]);

        $parentalControl->update($validated);

        return redirect()->route('admin.parental-controls.index')
            ->with('success', 'Parental control updated successfully!');
    }

    public function destroy(ParentalControl $parentalControl)
    {
        $parentalControl->delete();
        return back()->with('success', 'Parental control deleted successfully!');
    }
}
