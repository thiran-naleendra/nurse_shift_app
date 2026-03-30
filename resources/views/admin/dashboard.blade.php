@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Admin Dashboard</h1>
        <p class="text-sm text-slate-500">Master overview of all users and schedules</p>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Total Nurses</p>
            <h2 class="mt-3 text-3xl font-bold text-slate-900">{{ $totalUsers }}</h2>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Active Today</p>
            <h2 class="mt-3 text-3xl font-bold text-blue-600">{{ $activeToday }}</h2>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Shifts Today</p>
            <h2 class="mt-3 text-3xl font-bold text-emerald-600">{{ $totalShiftsToday }}</h2>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Leaves Today</p>
            <h2 class="mt-3 text-3xl font-bold text-rose-600">{{ $totalLeavesToday }}</h2>
        </div>
    </div>

    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">Recent Users</h3>
            <a href="{{ route('admin.users') }}" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                View All Users
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-50">
                    <tr class="text-left text-sm text-slate-600">
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Phone</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @foreach($recentUsers as $user)
                        <tr>
                            <td class="px-4 py-3">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">{{ $user->phone ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="rounded-lg bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection