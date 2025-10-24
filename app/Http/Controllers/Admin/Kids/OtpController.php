<?php

namespace App\Http\Controllers\Admin\Kids;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use App\Models\VerfactionEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function index()
    {
        $verifications = VerfactionEmail::paginate(15);
        return view('admin.verifications.index', compact('verifications'));
    }

    // public function create()
    // {
    //     $users = User::all()->toArray();
    //     return view('admin.otps.create', compact('users'));
    // }


    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'user_id' => 'nullable|exists:users,id',
    //         'expires_at' => 'required|date',
    //         'purpose' => 'nullable|string|max:255',
    //     ]);

    //     // توليد OTP تلقائي (6 أرقام عشوائية)
    //     $data['code'] = mt_rand(100000, 999999);

    //     // قيمة الافتراضية: لم يستخدم بعد
    //     $data['used'] = false;

    //     Otp::create($data);

    //     return redirect()->route('otps.index')->with('success', 'OTP created successfully.');
    // }


    // public function show(Otp $otp)
    // {
    //     return view('admin.otps.show', compact('otp'));
    // }

    // public function edit(Otp $otp)
    // {
    //     $users = User::all()->toArray();
    //     return view('admin.otps.edit', compact('otp', 'users'));
    // }

    // public function update(Request $request, Otp $otp)
    // {
    //     $request->validate([
    //         'user_id' => 'nullable|exists:users,id',
    //         'code' => 'required|string|max:10',
    //         'expires_at' => 'required|date',
    //         'used' => 'required|boolean',
    //         'purpose' => 'nullable|string|max:255',
    //     ]);

    //     $otp->update($request->all());

    //     return redirect()->route('otps.index')->with('success', 'OTP updated successfully.');
    // }

    // public function destroy(Otp $otp)
    // {
    //     $otp->delete();
    //     return redirect()->route('otps.index')->with('success', 'OTP deleted successfully.');
    // }
}
