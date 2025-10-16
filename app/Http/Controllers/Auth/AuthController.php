<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerfiyEmail;
use App\Models\Kid;
use App\Models\User;
use App\Models\VerfactionEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    function login()
    {
        return  view('auth.login');
    }

    function register()
    {
        return  view('auth.register');
    }

    function signin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            // Check if user is banned
            if ($user->banned) {
                Auth::logout();
                return redirect()->route('login')->with('errorlogin', 'Your account has been banned. Please contact the administrator.');
            }

            // if ($user->email_verified_at === null) {
            //     Auth::logout();
            //     return redirect()->back()->withErrors(['errorlogin' => 'يرجى التحقق من بريدك الإلكتروني لتفعيل الحساب.']);
            // }
            $role = $user->role->name;
            $request->session()->regenerate();
            if ($role === 'admin') {
                return to_route('admin.index');
                // dd($role);
            }
            //  elseif ($role === 'employee') {
            //     if ($roleName === 'accountant') {
            //         return redirect()->route('admin.index'); // لوحة تحكم المحاسب
            //     }
            //     return redirect()->route('admin.index'); // لوحة تحكم الموظف
            // } elseif ($role === 'client') {
            //     return redirect()->route('login');
            // }
        }

        return redirect()->route('admin.index');

        // return redirect()->back();
    }


    public function signup(Request $request)
    {
        // Validate Parent Info
        $request->validate([
            'parentName' => 'required|string|max:255',
            'parentEmail' => 'required|email|unique:users,email',
            'parentPassword' => 'required|confirmed|min:6', // parentPassword_confirmation
            'children.*.name' => 'required|string|max:255',
            'children.*.dob' => 'required|date',
            'children.*.gender' => 'required|in:male,female,other',
        ]);

        // Get parent role id
        $parentRoleId = DB::table('roles')->where('name', 'parent')->value('id');

        // Create Parent User
        $parent = User::create([
            'name' => $request->parentName,
            'email' => $request->parentEmail,
            'password' => Hash::make($request->parentPassword),
            'role_id' => $parentRoleId,
        ]);

        // Create Children
        if ($request->has('children')) {
            foreach ($request->children as $child) {
                // Create Child using Eloquent
                $kid = Kid::create([
                    'user_id' => $parent->id, // إذا كنت تستخدم جدول parent_children فلا تحتاجه هنا
                    'display_name' => $child['name'],
                    'dob' => $child['dob'],
                    'gender' => $child['gender'],
                    'points' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // ربط الطفل بالوالد في جدول parent_children
                $parent->children()->attach($kid->id);
            }
        }


        // return redirect()->route('login')->with('verify', 'تم تسجيل الحساب بنجاح وتم ارسال رابط التفعيل عبر الايميل');
        return redirect()->route('login')->with([
            'success' => 'Account and children created successfully! Please log in.'
        ]);
    }



    // function signup(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required',
    //         'password_confirmation' => 'required|same:password',
    //     ]);
    //     $createuser = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         // 'password_confirmation'=> $request->password_confirmation,
    //     ]);

    //     // mail verfiction:link,otp
    //     if ($createuser) {
    //         $otp = mt_rand(100000, 999999); // بتولد ارقام عشوائية مكونة من 6لا خانات
    //         $token = Str::random(50); // 50 خانة

    //         VerfactionEmail::create([
    //             'email' => $createuser->email,
    //             'otp' => $otp,
    //             'token' => $token,
    //             'expire' => 10,
    //         ]);

    //         $verfactionurl = url('verfactionemail/' . $token);
    //         Mail::to($createuser->email)->send(new VerfiyEmail($verfactionurl, $otp));

    //         return redirect()->route('login')->with('verify', 'تم تسجيل الحساب بنجاح وتم ارسال رابط التفعيل عبر الايميل ');
    //     }

    //     return to_route('login');
    // }



    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return  redirect()->route('login');
    }
}


//  // إنشاء OTP مؤقت صالح لمدة 10 دقائق
//     $otp = Otp::create([
//         'user_id' => $user->id,
//         'code' => mt_rand(100000, 999999), // OTP 6 أرقام
//         'expires_at' => Carbon::now()->addMinutes(10),
//         'used' => false,
//         'purpose' => 'email_verification',
//     ]);

//     // إرسال البريد
//     Mail::to($user->email)->send(new \App\Mail\SendOtpMail($otp));

//     // إعادة التوجيه إلى صفحة التحقق من OTP
//     return redirect()->route('otp.verify.form', $user->id);


// public function verifyOtp(Request $request, $userId)
// {
//     $request->validate(['code' => 'required|digits:6']);

//     $otp = Otp::where('user_id', $userId)
//               ->where('code', $request->code)
//               ->where('purpose', 'email_verification')
//               ->where('used', false)
//               ->first();

//     if (!$otp || $otp->expires_at->isPast()) {
//         return back()->withErrors(['code' => 'Invalid or expired OTP']);
//     }

//     // علامة على أن المستخدم تم تفعيله
//     $user = $otp->user;
//     $user->email_verified_at = now();
//     $user->save();

//     // وضع علامة على أن OTP تم استخدامه
//     $otp->used = true;
//     $otp->save();

//     // تسجيل دخول المستخدم تلقائيًا
//     auth()->login($user);

//     return redirect()->route('login')->with('success', 'Account verified successfully!');
// }
