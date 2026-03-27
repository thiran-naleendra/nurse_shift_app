@extends('layouts.app')

@section('content')
<div class="mx-auto flex min-h-[80vh] max-w-xl items-center justify-center">
    <div class="w-full rounded-3xl bg-white p-8 shadow-2xl">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-slate-800">Create Account</h2>
            <p class="mt-2 text-sm text-slate-500">Register and verify with OTP</p>
        </div>

        <form method="POST" action="{{ route('register.submit') }}" class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            @csrf

            <div class="sm:col-span-2">
                <label class="mb-2 block text-sm font-medium text-slate-700">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100">
            </div>

            <div class="sm:col-span-2">
                <label class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100">
            </div>

            <div class="sm:col-span-2">
                <label class="mb-2 block text-sm font-medium text-slate-700">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100">
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Password</label>
                <input type="password" name="password" required
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100">
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100">
            </div>

            <div class="sm:col-span-2">
                <button class="w-full rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white hover:bg-emerald-700">
                    Create Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection