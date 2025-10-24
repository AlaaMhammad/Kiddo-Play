<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use App\Models\VerfactionEmail;
use Illuminate\Http\Request;

class VerficationEmailController extends Controller
{
    // تحقق من الـ token
    public function verifyEmailToken(Request $request)
    {
        $token = $request->query('token');
        // Find verification by token
        $verification = VerfactionEmail::where('token', $token)->first();

        if (!$verification) {
            return response()->json([
                'status' => 0,
                'message' => 'Invalid or non-existent token'
            ], 404);
        }

        if (!$verification->expire || Carbon::now()->gt(Carbon::parse($verification->expire))) {
            return response()->json([
                'status' => 0,
                'message' => 'Expired Token'
            ], 410);
        }


        return response()->json([
            'status' => 1,
            'message' => 'Token is valid',
            'email' => $verification->email,
            'otp' => $verification->otp, // Remove this line if you don't want to expose the OTP
            'expire' => $verification->expire
        ]);
    }

    // تحقق من الـ OTP
    public function verifyEmailOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string'
        ]);

        $verfaction = VerfactionEmail::where('otp', $request->otp)->first();

        if (!$verfaction) {
            return response()->json([
                'status' => 0,
                'message' => 'Invalid OTP'
            ], 400);
        }

        $user = User::where('email', $verfaction->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'User not found'
            ], 404);
        }

        $user->email_verified_at = Carbon::now();
        $user->save();

        // حذف السجل بعد التحقق
        $verfaction->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Account activated successfully'
        ]);
    }
}
