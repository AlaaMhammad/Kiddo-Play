<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.account.index', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/users', 'public');
            $user->image = $path;
        }

        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        $user->save();

        return response()->json(['status' => 1, 'message' => 'Profile updated successfully', 'data' => $user]);
    }

    public function change_password(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with('error', 'Wrong current password');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully');
    }


    // public function delete(Request $request)
    // {
    //     /** @var \App\Models\User $user */
    //     $user = Auth::user();

    //     if (!$user) {
    //         return response()->json(['status' => 0, 'message' => 'User not found']);
    //     }

    //     $user->delete();

    //     return response()->json(['status' => 1, 'message' => 'Account deleted successfully']);
    // }
    public function delete(Request $request)
    {
        $request->validate([
            'accountActivation' => 'accepted', // يجب أن يكون الـ checkbox مؤكد
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // تسجيل خروج المستخدم
        Auth::logout();

        // حذف الحساب
        $user->delete();
        flash()->success('Your account has been deleted successfully.');
        // إعادة توجيه مع رسالة نجاح
        return redirect('/');
    }
}
