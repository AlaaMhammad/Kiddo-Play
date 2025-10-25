<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerfiyEmail;
use App\Models\Avatar;
use App\Models\Kid;
use App\Models\User;
use App\Models\VerfactionEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;

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

            if (in_array($user->role->name, ['parent']) && $user->email_verified_at === null) {
                Auth::logout();
                flash()->error('Please check your email to activate your account.');
                return redirect()->back();
            }
            $role = $user->role?->name;
            $request->session()->regenerate();
            if ($role === 'admin') {
                return to_route('admin.index');
                // dd($role);
            } elseif ($role === 'parent') {
                return redirect()->route('admin.index'); // لوحة تحكم المحاسب
            } elseif ($role === 'kid') {
                return redirect()->route('admin.index'); // لوحة تحكم المحاسب

            }
        }

        return redirect()->route('admin.index');

        // return redirect()->back();
    }


    public function signup(Request $request)
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

        // إنشاء الوالد
        $parent = User::create([
            'name' => $request->parentName,
            'email' => $request->parentEmail,
            'password' => Hash::make($request->parentPassword),
            'plain_password' => $request->parentPassword,
            'role_id' => $parentRoleId,
        ]);

        // إنشاء الأطفال (إن وجدوا)
        if ($request->add_child === 'Yes' && $request->has('children')) {
            foreach ($request->children as $child) {
                $childUser = User::create([
                    'name' => $child['name'],
                    'email' => $child['email'],
                    'password' => Hash::make($child['password']),
                    'plain_password' => $child['password'],
                    'role_id' => $kidRoleId,
                ]);

                $defaultAvatar = Avatar::whereRaw('LOWER(name) = ?', ['default'])
                    ->where('is_active', true)
                    ->first();

                $kid = Kid::create([
                    'user_id' => $childUser->id,
                    'display_name' => $child['name'],
                    'dob' => $child['dob'],
                    'gender' => $child['gender'],
                    'points' => 0,
                    'avatar_id' => $defaultAvatar ? $defaultAvatar->id : null,
                ]);


                $parent->children()->attach($kid->id);
            }
        }

        // الآن بعد إنشاء الجميع، نرسل التفعيل
        if ($parent) {
            $otp = mt_rand(100000, 999999);
            $token = Str::random(50);

            VerfactionEmail::create([
                'email' => $parent->email,
                'otp' => $otp,
                'token' => $token,
                'expire' => now()->addMinutes(10),
            ]);

            $verfactionurl = url('verfactionemail/' . $token);
            Mail::to($parent->email)->send(new VerfiyEmail($verfactionurl, $otp));
        }

        flash()->success('Account created successfully. Please verify your email.');
        return redirect()->route('login');
    }



    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email', 'This email does not exist.'])->withInput();
        }
        flash()->success('Email successfully');
        // إذا البريد صحيح → نوجه المستخدم لصفحة إدخال كلمة المرور الجديدة
        return redirect()->route('set_new_password', ['email' => $request->email]);
    }

    // عرض صفحة إدخال كلمة المرور الجديدة
    public function showNewPasswordForm($email)
    {
        return view('auth.reset-password', compact('email'));
    }

    // حفظ كلمة المرور الجديدة
    public function saveNewPassword(Request $request, $email)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::where('email', $email)->firstOrFail();

        $user->password = Hash::make($request->password);
        $user->save();
        flash()->success('Password updated successfully. You can now log in.');
        return redirect()->route('login');
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
