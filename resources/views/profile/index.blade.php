@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-6xl space-y-6">

    {{-- User Info Card --}}
    <div class="rounded-[2rem] bg-gradient-to-br from-blue-700 via-blue-600 to-cyan-500 p-6 text-white shadow-xl">
        <div class="flex items-center gap-4">
            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-xl font-bold text-blue-700 shadow">
                {{ strtoupper(substr(auth()->user()->name ?? 'T', 0, 1)) }}
            </div>
            <div>
                <h1 class="text-xl font-bold">
                    {{ auth()->user()->name ?? 'Thiran Naleendra' }}
                </h1>
                <p class="text-sm text-blue-100">
                    {{ auth()->user()->email }}
                </p>
                <p class="text-xs text-blue-200">
                    {{ auth()->user()->phone ?? '0705651875' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Two cards in same row --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 lg:items-start">

        {{-- Update Form --}}
        <div class="rounded-3xl bg-white p-6 shadow-sm sm:p-8">
            <h2 class="mb-5 text-lg font-semibold text-slate-900">Update Profile</h2>

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Name</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', auth()->user()->name) }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Mobile Number</label>
                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone', auth()->user()->phone) }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                    <input
                        type="email"
                        value="{{ auth()->user()->email }}"
                        disabled
                        class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-500"
                    >
                </div>

                <div class="pt-2">
                    <button
                        class="w-full rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>

        {{-- Developer Info Card --}}
        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
            <h3 class="mb-4 text-lg font-semibold text-slate-900">About Application</h3>

            <div class="space-y-4 text-sm text-slate-600">
                <div class="rounded-2xl bg-slate-50 p-4">
                    <p>
                        <span class="font-semibold text-slate-800">App:</span> Nurse Shift App
                    </p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4">
                    <p>
                        <span class="font-semibold text-slate-800">Developer:</span> Thiran Naleendra
                    </p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4">
                    <p>
                        <span class="font-semibold text-slate-800">Contact:</span> 0705651875
                    </p>
                </div>

                <div class="rounded-2xl bg-blue-50 p-4">
                    <p class="leading-6 text-slate-700">
                        This system is built to help nurses manage daily shifts and leave records efficiently with calendar and reporting features.
                    </p>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection