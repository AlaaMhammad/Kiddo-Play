<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\VerfactionEmail;
use App\Mail\VerfiyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // تسجيل الدخول
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

        if (in_array($user->role->name, ['parent']) && $user->email_verified_at === null) {
            Auth::logout();
            return response()->json(['message' => 'Please verify your email before logging in'], 403);
        }

        // إذا عنده توكنات نشطة، نرجع رسالة بدون بيانات المستخدم
        // if ($user->tokens()->exists()) {
        //     return response()->json([
        //         'message' => 'User already logged in',
        //         'token' => $user->tokens()->latest()->first()->plainTextToken ?? null
        //     ]);
        // }

        $user->tokens()->delete(); // حذف التوكنات السابقة

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
            'add_child' => 'required',
            'children' => 'nullable|array|min:1',
            'children.*.name' => 'nullable|string|max:255',
            'children.*.dob' => 'nullable|date',
            'children.*.gender' => 'nullable|in:male,female,other',
            'children.*.email' => 'nullable|email|distinct|unique:users,email',
            'children.*.password' => 'nullable|confirmed|min:6',
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

        // mail verfiction:link,otp
        if ($parent) {
            $otp = mt_rand(100000, 999999); // بتولد ارقام عشوائية مكونة من 6لا خانات
            $token = Str::random(50); // 50 خانة

            VerfactionEmail::create([
                'email' => $parent->email,
                'otp' => $otp,
                'token' => $token,
                'expire' => now()->addMinutes(10)->format('Y-m-d H:i:s'),
            ]);

            $verfactionurl = url('verfactionemail/' . $token);
            Mail::to($parent->email)->send(new VerfiyEmail($verfactionurl, $otp));
            return response()->json([
                'message' => 'Account created successfully. Please verify your email.',
                'expire' => now()->addMinutes(10)->format('Y-m-d H:i:s'),
                'token' => $token

            ]);
        }

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
