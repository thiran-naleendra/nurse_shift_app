@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h1>
        <p class="text-sm text-slate-500">User profile and schedule details</p>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-slate-900">User Info</h3>

            <div class="mt-4 space-y-3 text-sm">
                <p><span class="font-semibold">Email:</span> {{ $user->email }}</p>
                <p><span class="font-semibold">Phone:</span> {{ $user->phone ?? '-' }}</p>
                <p><span class="font-semibold">Employee Code:</span> {{ $user->nurseProfile->employee_code ?? '-' }}</p>
                <p><span class="font-semibold">Department:</span> {{ $user->nurseProfile->department ?? '-' }}</p>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm lg:col-span-2">
            <h3 class="text-lg font-semibold text-slate-900">Schedules</h3>

            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-slate-50">
                        <tr class="text-left text-sm text-slate-600">
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3">Shift / Leave</th>
                            <th class="px-4 py-3">Start</th>
                            <th class="px-4 py-3">End</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($user->nurseProfile->scheduleEntries ?? [] as $item)
                            <tr>
                                <td class="px-4 py-3">{{ ucfirst($item->entry_type) }}</td>
                                <td class="px-4 py-3">
                                    {{ $item->entry_type === 'shift' ? $item->shiftType?->name : $item->leaveType?->name }}
                                </td>
                                <td class="px-4 py-3">{{ $item->start_datetime }}</td>
                                <td class="px-4 py-3">{{ $item->end_datetime }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-slate-500">No schedule records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection