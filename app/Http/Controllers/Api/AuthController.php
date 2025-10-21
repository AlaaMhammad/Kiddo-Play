<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // تسجيل الدخول
    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     if (!Auth::attempt($request->only('email', 'password'))) {
    //         return response()->json(['message' => 'Invalid credentials'], 401);
    //     }

    //     /** @var User $user */
    //     $user = Auth::user();

    //     if ($user->banned) {
    //         return response()->json(['message' => 'Your account is banned'], 403);
    //     }

    //     // تحقق إذا عنده توكنات نشطة
    //     if ($user->tokens()->exists()) {
    //         return response()->json([
    //             'message' => 'User already logged in',
    //             'user' => $user
    //         ]);
    //     }

    //     // إنشاء توكن جديد
    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()->json([
    //         'message' => 'Login successful',
    //         'user' => $user,
    //         'token' => $token
    //     ]);
    // }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        /** @var User $user */
        $user = Auth::user();

        if ($user->banned) {
            return response()->json(['message' => 'Your account is banned'], 403);
        }

        // إذا عنده توكنات نشطة، نرجع رسالة بدون بيانات المستخدم
        if ($user->tokens()->exists()) {
            return response()->json([
                'message' => 'User already logged in',
                'token' => $user->tokens()->latest()->first()->plainTextToken ?? null
            ]);
        }

        // $user->tokens()->delete(); // حذف التوكنات السابقة

        // إنشاء توكن جديد
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token
        ]);
    }

    // تسجيل حساب جديد
    public function register(Request $request)
    {
        $request->validate([
            'parentName' => 'required|string|max:255',
            'parentEmail' => 'required|email|unique:users,email',
            'parentPassword' => 'required|confirmed|min:6',
            'children' => 'sometimes|array|min:1',
            'children.*.name' => 'sometimes|string|max:255',
            'children.*.dob' => 'sometimes|date',
            'children.*.gender' => 'sometimes|in:male,female,other',
            'children.*.email' => 'sometimes|email|distinct|unique:users,email',
            'children.*.password' => 'sometimes|confirmed|min:6',
        ]);

        $parentRoleId = DB::table('roles')->where('name', 'parent')->value('id');
        $kidRoleId = DB::table('roles')->where('name', 'kid')->value('id');

        $parent = User::create([
            'name' => $request->parentName,
            'email' => $request->parentEmail,
            'password' => Hash::make($request->parentPassword),
            'plain_password' => $request->parentPassword,
            'role_id' => $parentRoleId,
        ]);

        foreach ($request->children as $child) {
            $childUser = User::create([
                'name' => $child['name'],
                'email' => $child['email'],
                'password' => Hash::make($child['password']),
                'plain_password' => $child['password'],
                'role_id' => $kidRoleId,
            ]);

            $kid = Kid::create([
                'user_id' => $childUser->id,
                'display_name' => $child['name'],
                'dob' => $child['dob'],
                'gender' => $child['gender'],
                'points' => 0,
            ]);

            $parent->children()->attach($kid->id);
        }

        return response()->json(['message' => 'Parent and children registered successfully']);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email not found'], 404);
        }

        // هنا ممكن ترسل OTP أو رابط إعادة تعيين
        // مثال بسيط بدون إرسال فعلي:
        return response()->json([
            'message' => 'Email is valid. Proceed to reset.',
            'email' => $user->email
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password reset successfully']);
    }

    // تسجيل الخروج
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
