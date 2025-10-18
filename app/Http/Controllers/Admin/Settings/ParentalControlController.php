<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\ParentalControl;
use App\Models\User;
use App\Models\Kid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentalControlController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            $controls = ParentalControl::with(['parent', 'kid'])->latest()->paginate(10);
        } elseif ($user->role->name === 'parent') {
            // الأب يرى سجلاته وسجلات أطفاله
            $kidsIds = $user->children()->pluck('kids.id');
            $controls = ParentalControl::where(function ($q) use ($user, $kidsIds) {
                $q->where('parent_id', $user->id)
                    ->orWhereIn('kid_id', $kidsIds);
            })->with(['parent', 'kid'])->latest()->paginate(10);
        } elseif ($user->role->name === 'kid') {
            // الطفل يرى سجلاته فقط
            $controls = ParentalControl::where('kid_id', $user->kid?->id)
                ->with(['parent', 'kid'])->latest()->paginate(10);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.Settings.parental-controls.index', compact('controls'));
    }

    public function show(ParentalControl $parentalControl)
    {
        $this->authorizeView($parentalControl);
        return view('admin.Settings.parental-controls.show', compact('parentalControl'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        $parents = User::pluck('name', 'id');
        $kids = Kid::pluck('display_name', 'id');
        return view('admin.Settings.parental-controls.create', compact('parents', 'kids'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

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

    public function edit(ParentalControl $parentalControl)
    {
        $this->authorizeAdmin();
        $parents = User::pluck('name', 'id');
        $kids = Kid::pluck('display_name', 'id');
        return view('admin.Settings.parental-controls.edit', compact('parentalControl', 'parents', 'kids'));
    }

    public function update(Request $request, ParentalControl $parentalControl)
    {
        $this->authorizeAdmin();

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
        $this->authorizeAdmin();
        $parentalControl->delete();
        return back()->with('success', 'Parental control deleted successfully!');
    }

    private function authorizeAdmin()
    {
        $user = Auth::user();
        abort_unless($user && $user->role->name === 'admin', 403, 'Unauthorized action.');
    }

    private function authorizeView(ParentalControl $parentalControl)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') return;

        if ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id');
            abort_unless($parentalControl->parent_id === $user->id || in_array($parentalControl->kid_id, $kidsIds->toArray()), 403, 'Unauthorized access.');
        }

        if ($user->role->name === 'kid') {
            abort_unless($parentalControl->kid_id === $user->kid?->id, 403, 'Unauthorized access.');
        }
    }
}
