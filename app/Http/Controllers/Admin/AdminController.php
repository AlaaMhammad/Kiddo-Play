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

        $request->mergeIfMissing(['admin_id' => auth()->user()->id]);
        $admin = User::find($request->admin_id);

        $validator = Validator::make($request->all(), [
            'admin_id' => 'required|exists:admins,id',
            'name' => 'sometimes|string',
            'email' => ['sometimes', 'email', Rule::unique('admins')->ignore($admin->id)],
            'image' => 'sometimes|mimetypes:image/*',
            'status' => 'sometimes|in:0,1',
            'role' => 'sometimes|in:0,1,2,3,4,5',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 0,
                    'message' => $validator->errors()->first()
                ]
            );
        }

        try {

            $admin->update($request->except('image'));

            if ($request->hasFile('image')) {
                $url = $request->image->store('/uploads/admins/images', 'upload');
                $admin->image = $url;
                $admin->save();
            }

            return response()->json([
                'status' => 1,
                'message' => 'success',
                'data' => $admin
            ]);
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => 0,
                    'message' => $e->getMessage()
                ]
            );
        }
    }

    public function delete(Request $request)
    {

        $request->mergeIfMissing(['admin_id' => auth()->user()->id]);

        $validator = Validator::make($request->all(), [
            'admin_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 0,
                    'message' => $validator->errors()->first()
                ]
            );
        }

        try {

            $admin = User::findOrFail($request->admin_id);

            $admin->delete();

            return response()->json([
                'status' => 1,
                'message' => 'success',
            ]);
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => 0,
                    'message' => $e->getMessage()
                ]
            );
        }
    }
    public function change_password(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);



        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = auth()->user();

        if (Hash::check($request->old_password, $user->password)) {

            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'status' => 1,
                'message' => __('password changed')
            ]);
        } else {

            return response()->json([
                'status' => 0,
                'message' => __('wrong password')
            ]);
        }
    }
}
