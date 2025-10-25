<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $user = Auth::user();

        return response()->json([
            'status' => 1,
            'message' => 'Profile retrieved successfully',
            'data' => $user,
        ]);
    }

    public function updateProfile(Request $request)
    {
        /** @var User $user */
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

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        /** @var User $user */
        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['status' => 0, 'message' => 'Wrong current password']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['status' => 1, 'message' => 'Password changed successfully']);
    }

    public function deleteAccount(Request $request)
    {
        // $request->validate([
        //     'account_activation' => 'accepted',
        // ]);
        /** @var User $user */
        $user = Auth::user();

        // حذف التوكن الحالي فقط
        $user->currentAccessToken()->delete();

        // حذف الحساب
        $user->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Your account has been deleted successfully'
        ]);
    }
}
