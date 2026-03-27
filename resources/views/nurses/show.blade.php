@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $nurse->user->name }}</h1>
            <p class="text-sm text-slate-500">Nurse profile details and recent schedules</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('nurses.edit', $nurse->id) }}"
               class="rounded-2xl bg-amber-500 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-600">
                Edit
            </a>
            <a href="{{ route('nurses.index') }}"
               class="rounded-2xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="rounded-3xl bg-white p-6 shadow-sm lg:col-span-1">
            <h3 class="text-lg font-semibold text-slate-900">Profile Info</h3>

            <div class="mt-5 space-y-4 text-sm">
                <div>
                    <p class="text-slate-500">Email</p>
                    <p class="font-medium text-slate-900">{{ $nurse->user->email }}</p>
                </div>

                <div>
                    <p class="text-slate-500">Phone</p>
                    <p class="font-medium text-slate-900">{{ $nurse->user->phone ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-slate-500">Employee Code</p>
                    <p class="font-medium text-slate-900">{{ $nurse->employee_code }}</p>
                </div>

                <div>
                    <p class="text-slate-500">Department</p>
                    <p class="font-medium text-slate-900">{{ $nurse->department ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-slate-500">Designation</p>
                    <p class="font-medium text-slate-900">{{ $nurse->designation ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-slate-500">Join Date</p>
                    <p class="font-medium text-slate-900">{{ $nurse->join_date ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-slate-500">Status</p>
                    <p class="font-medium text-slate-900">{{ ucfirst($nurse->status) }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm lg:col-span-2">
            <h3 class="text-lg font-semibold text-slate-900">Recent Schedule Entries</h3>

            <div class="mt-5 overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-slate-50">
                        <tr class="text-left text-sm text-slate-600">
                            <th class="px-4 py-3 font-semibold">Type</th>
                            <th class="px-4 py-3 font-semibold">Shift / Leave</th>
                            <th class="px-4 py-3 font-semibold">Start</th>
                            <th class="px-4 py-3 font-semibold">End</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($nurse->scheduleEntries->take(10) as $entry)
                            <tr>
                                <td class="px-4 py-3">{{ ucfirst($entry->entry_type) }}</td>
                                <td class="px-4 py-3">
                                    {{ $entry->entry_type === 'shift' ? $entry->shiftType?->name : $entry->leaveType?->name }}
                                </td>
                                <td class="px-4 py-3">{{ $entry->start_datetime }}</td>
                                <td class="px-4 py-3">{{ $entry->end_datetime }}</td>
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