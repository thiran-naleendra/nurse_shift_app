<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OtpVerification;
use App\Notifications\SendOtpNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'is_active' => 1
        ])) {
            return back()->withErrors([
                'email' => 'Invalid email or password.'
            ])->withInput();
        }

        $request->session()->regenerate();

        if (is_null(auth()->user()->email_verified_at)) {
            session(['otp_user_id' => auth()->id()]);
            Auth::logout();

            return redirect()->route('verify.otp')
                ->with('error', 'Please verify your account with OTP first.');
        }

        return redirect()->route('dashboard')
            ->with('success', 'Login successful.');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user = null;

        DB::transaction(function () use ($data, &$user) {
            $user = User::create([
                'role' => 'nurse',
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => Hash::make($data['password']),
                'is_active' => 1,
                'email_verified_at' => null,
            ]);

            OtpVerification::where('user_id', $user->id)
                ->where('purpose', 'register')
                ->delete();

            $otpCode = (string) random_int(100000, 999999);

            OtpVerification::create([
                'user_id' => $user->id,
                'otp_code' => $otpCode,
                'purpose' => 'register',
                'expires_at' => now()->addMinutes(10),
            ]);

            $user->notify(new SendOtpNotification($otpCode));
        });

        session(['otp_user_id' => $user->id]);

        return redirect()->route('verify.otp')
            ->with('success', 'Account created. OTP has been sent to your email.');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', __($status));
        }

        return back()->withErrors([
            'email' => __($status),
        ]);
    }

    public function showResetPassword(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', __($status));
        }

        return back()->withErrors([
            'email' => [__($status)],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Logged out successfully.');
    }
}