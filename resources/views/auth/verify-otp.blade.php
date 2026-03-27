@extends('layouts.app')

@section('content')
<div class="mx-auto flex min-h-[80vh] max-w-md items-center justify-center">
    <div class="w-full rounded-3xl bg-white p-8 shadow-2xl">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-slate-800">Verify OTP</h2>
            <p class="mt-2 text-sm text-slate-500">Enter the code sent to your email</p>
        </div>

        <form method="POST" action="{{ route('verify.otp.submit') }}" class="space-y-5">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">OTP Code</label>
                <input type="text" name="otp_code" maxlength="6" required
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-center text-xl tracking-[0.4em] outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
            </div>

            <button class="w-full rounded-2xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                Verify OTP
            </button>
        </form>

        <form method="POST" action="{{ route('resend.otp') }}" class="mt-4">
            @csrf
            <button class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Resend OTP
            </button>
        </form>
    </div>
</div>
@endsection