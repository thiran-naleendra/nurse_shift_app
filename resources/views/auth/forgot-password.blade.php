@extends('layouts.app')

@section('content')
<div class="mx-auto flex min-h-[85vh] max-w-6xl items-center justify-center px-4 py-6 sm:px-6 lg:px-8">
    <div class="grid w-full overflow-hidden rounded-[2rem] bg-white shadow-2xl lg:grid-cols-2">

        {{-- Left panel --}}
        <div class="relative hidden overflow-hidden bg-gradient-to-br from-indigo-700 via-blue-600 to-cyan-500 p-10 text-white lg:flex lg:flex-col lg:justify-between">
            <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-white/10 blur-2xl"></div>
            <div class="absolute -bottom-20 -left-10 h-56 w-56 rounded-full bg-cyan-300/20 blur-3xl"></div>

            <div class="relative z-10">
                <div class="inline-flex items-center gap-3 rounded-2xl bg-white/10 px-4 py-3 backdrop-blur">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-indigo-700 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 1a5 5 0 0 0-5 5v3H6a2 2 0 0 0-2 2v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4v-8a2 2 0 0 0-2-2h-1V6a5 5 0 0 0-5-5Zm-3 8V6a3 3 0 1 1 6 0v3H9Zm3 4a2 2 0 0 1 1 3.73V18a1 1 0 1 1-2 0v-1.27A2 2 0 0 1 12 13Z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Password Recovery</p>
                        <p class="text-xs text-blue-100">Secure reset by email link</p>
                    </div>
                </div>

                <div class="mt-10">
                    <h1 class="max-w-md text-4xl font-bold leading-tight">
                        Reset your account safely.
                    </h1>
                    <p class="mt-4 max-w-md text-sm leading-6 text-blue-50">
                        Enter your email address and we will send a secure password reset link to help you access your nurse dashboard again.
                    </p>
                </div>
            </div>

            <div class="relative z-10 grid gap-4">
                <div class="rounded-3xl bg-white/10 p-5 backdrop-blur">
                    <p class="text-sm font-semibold">Step 1</p>
                    <p class="mt-1 text-sm text-blue-100">Enter your registered email address.</p>
                </div>

                <div class="rounded-3xl bg-white/10 p-5 backdrop-blur">
                    <p class="text-sm font-semibold">Step 2</p>
                    <p class="mt-1 text-sm text-blue-100">Open the reset link from your inbox.</p>
                </div>

                <div class="rounded-3xl bg-white/10 p-5 backdrop-blur">
                    <p class="text-sm font-semibold">Step 3</p>
                    <p class="mt-1 text-sm text-blue-100">Create a new password and log back in.</p>
                </div>
            </div>
        </div>

        {{-- Right panel --}}
        <div class="flex items-center justify-center bg-white px-5 py-8 sm:px-8 sm:py-10 lg:px-12">
            <div class="w-full max-w-md">
                {{-- mobile brand --}}
                <div class="mb-8 text-center lg:hidden">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-[1.25rem] bg-indigo-600 text-white shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 1a5 5 0 0 0-5 5v3H6a2 2 0 0 0-2 2v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4v-8a2 2 0 0 0-2-2h-1V6a5 5 0 0 0-5-5Zm-3 8V6a3 3 0 1 1 6 0v3H9Zm3 4a2 2 0 0 1 1 3.73V18a1 1 0 1 1-2 0v-1.27A2 2 0 0 1 12 13Z"/>
                        </svg>
                    </div>
                    <h1 class="mt-4 text-xl font-bold text-slate-900">Forgot Password</h1>
                    <p class="mt-1 text-sm text-slate-500">We’ll send you a reset link</p>
                </div>

                <div class="mb-8 hidden lg:block">
                    <div class="flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-[1.25rem] bg-indigo-100 text-indigo-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 1a5 5 0 0 0-5 5v3H6a2 2 0 0 0-2 2v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4v-8a2 2 0 0 0-2-2h-1V6a5 5 0 0 0-5-5Zm-3 8V6a3 3 0 1 1 6 0v3H9Zm3 4a2 2 0 0 1 1 3.73V18a1 1 0 1 1-2 0v-1.27A2 2 0 0 1 12 13Z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold text-slate-900">Forgot password?</h2>
                            <p class="mt-1 text-sm text-slate-500">Enter your email to receive a reset link</p>
                        </div>
                    </div>
                </div>

                <div class="mb-6 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex h-10 w-10 items-center justify-center rounded-2xl bg-white text-indigo-600 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4 6.75A2.75 2.75 0 0 1 6.75 4h10.5A2.75 2.75 0 0 1 20 6.75v10.5A2.75 2.75 0 0 1 17.25 20H6.75A2.75 2.75 0 0 1 4 17.25V6.75Zm2.3-.25 5.7 4.65 5.7-4.65H6.3Zm11.2 1.73-4.86 3.96a1 1 0 0 1-1.28 0L6.5 8.23v9.02c0 .41.34.75.75.75h10.5c.41 0 .75-.34.75-.75V8.23Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Email recovery</p>
                            <p class="text-xs leading-5 text-slate-500">
                                Use the email linked to your nurse account. The reset link will be sent there.
                            </p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M4 6.75A2.75 2.75 0 0 1 6.75 4h10.5A2.75 2.75 0 0 1 20 6.75v10.5A2.75 2.75 0 0 1 17.25 20H6.75A2.75 2.75 0 0 1 4 17.25V6.75Zm2.3-.25 5.7 4.65 5.7-4.65H6.3Zm11.2 1.73-4.86 3.96a1 1 0 0 1-1.28 0L6.5 8.23v9.02c0 .41.34.75.75.75h10.5c.41 0 .75-.34.75-.75V8.23Z"/>
                                </svg>
                            </span>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                placeholder="Enter your email"
                                class="w-full rounded-2xl border border-slate-300 py-3 pl-12 pr-4 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                            >
                        </div>
                    </div>

                    <button
                        class="w-full rounded-2xl bg-indigo-600 px-4 py-3.5 text-sm font-semibold text-white shadow-lg transition hover:bg-indigo-700 active:scale-[0.99]">
                        Send Reset Link
                    </button>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                            Back to login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection