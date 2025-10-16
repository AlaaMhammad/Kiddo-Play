<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Avatar;
use Illuminate\Http\Request;

class AvatarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $avatars = Avatar::latest()->paginate(10);
        return view('admin.avatars.index', compact('avatars'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.avatars.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'nullable|string|max:255',
            'image_url'    => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'cost_points'  => 'required|integer|min:0',
            'is_active'    => 'boolean',
        ]);

        $path = $request->file('image_url')->store('avatars', 'public');

        Avatar::create([
            'name'         => $request->name,
            'image_url'    => $path,
            'cost_points'  => $request->cost_points,
            'is_active'    => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.avatars.index')->with(['success'=>'Avatar created successfully.',
        'action' => 'create']);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Avatar $avatar)
    {
        return view('admin.avatars.edit', compact('avatar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Avatar $avatar)
    {
        $request->validate([
            'name'         => 'nullable|string|max:255',
            'image_url'    => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'cost_points'  => 'required|integer|min:0',
            'is_active'    => 'boolean',
        ]);

        $data = $request->only(['name', 'cost_points', 'is_active']);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image_url')) {
            $data['image_url'] = $request->file('image_url')->store('avatars', 'public');
        }

        $avatar->update($data);

        return redirect()->route('admin.avatars.index')->with(['success'=> 'Avatar updated successfully.', 'action' => 'update']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Avatar $avatar)
    {
        $avatar->delete();
        return redirect()->route('admin.avatars.index')->with([
            'success' => 'Avatar deleted successfully.',
            'action' => 'delete',
        ]);
    }
}
