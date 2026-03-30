@extends('layouts.app')

@section('content')
<div class="mx-auto flex min-h-[80vh] max-w-md items-center justify-center px-4">

    <div class="w-full rounded-[2rem] bg-white p-8 shadow-2xl sm:p-10">

        {{-- Header --}}
        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-600 text-white shadow">
                🔐
            </div>
            <h2 class="text-2xl font-bold text-slate-900 sm:text-3xl">Reset Password</h2>
            <p class="mt-2 text-sm text-slate-500">
                Enter your new password below
            </p>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            {{-- Email --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                >
            </div>

            {{-- Password --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">New Password</label>
                <input
                    type="password"
                    name="password"
                    required
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                >
            </div>

            {{-- Confirm Password --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    required
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                >
            </div>

            {{-- Button --}}
            <button
                class="w-full rounded-2xl bg-green-600 px-4 py-3 text-sm font-semibold text-white shadow hover:bg-green-700 transition">
                Reset Password
            </button>

            {{-- Back to login --}}
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                    Back to Login
                </a>
            </div>
        </form>

    </div>
</div>
@endsection