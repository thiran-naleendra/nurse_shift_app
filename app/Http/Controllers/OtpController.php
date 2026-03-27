<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OtpVerification;
use App\Notifications\SendOtpNotification;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function showForm()
    {
        return view('auth.verify-otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp_code' => ['required', 'digits:6'],
        ]);

        $userId = session('otp_user_id');

        if (!$userId) {
            return redirect()->route('register')
                ->with('error', 'OTP session expired. Please register again.');
        }

        $otp = OtpVerification::where('user_id', $userId)
            ->where('purpose', 'register')
            ->whereNull('verified_at')
            ->latest('id')
            ->first();

        if (!$otp) {
            return back()->with('error', 'OTP record not found.');
        }

        if ($otp->expires_at->isPast()) {
            return back()->with('error', 'OTP has expired. Please request a new one.');
        }

        if ($otp->otp_code !== $request->otp_code) {
            return back()->with('error', 'Invalid OTP code.');
        }

        $otp->update([
            'verified_at' => now(),
        ]);

        User::where('id', $userId)->update([
            'email_verified_at' => now(),
        ]);

        session()->forget('otp_user_id');

        return redirect()->route('login')
            ->with('success', 'Account verified successfully. Please login.');
    }

    public function resend()
    {
        $userId = session('otp_user_id');

        if (!$userId) {
            return redirect()->route('register')
                ->with('error', 'OTP session expired. Please register again.');
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('register')
                ->with('error', 'User not found.');
        }

        OtpVerification::where('user_id', $user->id)
            ->where('purpose', 'register')
            ->whereNull('verified_at')
            ->delete();

        $otpCode = (string) random_int(100000, 999999);

        OtpVerification::create([
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'purpose' => 'register',
            'expires_at' => now()->addMinutes(10),
        ]);

        $user->notify(new SendOtpNotification($otpCode));

        return back()->with('success', 'A new OTP has been sent to your email.');
    }
}