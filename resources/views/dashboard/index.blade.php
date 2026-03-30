@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="overflow-hidden rounded-[2rem] bg-gradient-to-br from-blue-700 via-blue-600 to-cyan-500 p-6 text-white shadow-xl sm:p-8">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-3 rounded-2xl bg-white/10 px-4 py-2 backdrop-blur">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white text-blue-700 shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11 2a2 2 0 0 1 2 2v1.07a7.002 7.002 0 0 1 5.93 5.93H20a2 2 0 1 1 0 4h-1.07A7.002 7.002 0 0 1 13 20.93V22a2 2 0 1 1-4 0v-1.07A7.002 7.002 0 0 1 3.07 15H2a2 2 0 1 1 0-4h1.07A7.002 7.002 0 0 1 9 5.07V4a2 2 0 0 1 2-2Zm1 7h-2v2H8v2h2v2h2v-2h2v-2h-2V9Z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">My Dashboard</p>
                        <p class="text-xs text-blue-100">Personal shift and leave summary</p>
                    </div>
                </div>

                <h1 class="mt-5 text-3xl font-bold leading-tight sm:text-4xl">
                    Welcome back, {{ auth()->user()->name }}
                </h1>
                <p class="mt-3 max-w-xl text-sm leading-6 text-blue-50 sm:text-base">
                    Quickly check today’s shifts, leave status, and your upcoming 7-day schedule.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 lg:w-[380px]">
                <a href="{{ route('schedules.create') }}"
                   class="rounded-2xl bg-white px-4 py-4 text-center text-sm font-semibold text-blue-700 shadow hover:bg-blue-50">
                    Add Schedule
                </a>

                <a href="{{ route('calendar.index') }}"
                   class="rounded-2xl bg-white/10 px-4 py-4 text-center text-sm font-semibold text-white backdrop-blur hover:bg-white/20">
                    Calendar
                </a>

                <a href="{{ route('schedules.index') }}"
                   class="rounded-2xl bg-white/10 px-4 py-4 text-center text-sm font-semibold text-white backdrop-blur hover:bg-white/20">
                    My Schedule
                </a>

                <a href="{{ route('reports.weekly') }}"
                   class="rounded-2xl bg-white/10 px-4 py-4 text-center text-sm font-semibold text-white backdrop-blur hover:bg-white/20">
                    Weekly Report
                </a>
            </div>
        </div>
    </div>

    {{-- Today stats --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-6">
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Today Full Day</p>
                <div class="rounded-2xl bg-blue-100 p-2 text-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2Zm1 11h4v-2h-3V7h-2v6Z"/>
                    </svg>
                </div>
            </div>
            <h2 class="mt-4 text-3xl font-bold text-blue-600">{{ $todayShifts->full_day ?? 0 }}</h2>
            <p class="mt-2 text-xs text-slate-500">7:00 AM - 7:00 PM</p>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Today Evening</p>
                <div class="rounded-2xl bg-amber-100 p-2 text-amber-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2Zm5 11h-6V7h2v4h4Z"/>
                    </svg>
                </div>
            </div>
            <h2 class="mt-4 text-3xl font-bold text-amber-500">{{ $todayShifts->evening ?? 0 }}</h2>
            <p class="mt-2 text-xs text-slate-500">1:00 PM - 7:00 PM</p>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Today Night</p>
                <div class="rounded-2xl bg-violet-100 p-2 text-violet-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M21 14.5A8.5 8.5 0 0 1 9.5 3a.75.75 0 0 0-.98.98A7 7 0 1 0 20.02 15.48a.75.75 0 0 0 .98-.98Z"/>
                    </svg>
                </div>
            </div>
            <h2 class="mt-4 text-3xl font-bold text-violet-600">{{ $todayShifts->night ?? 0 }}</h2>
            <p class="mt-2 text-xs text-slate-500">7:00 PM - Next day 7:00 AM</p>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Morning + Night</p>
                <div class="rounded-2xl bg-cyan-100 p-2 text-cyan-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2a1 1 0 0 1 1 1v1.268A8.001 8.001 0 0 1 19.732 11H21a1 1 0 1 1 0 2h-1.268A8.001 8.001 0 0 1 13 19.732V21a1 1 0 1 1-2 0v-1.268A8.001 8.001 0 0 1 4.268 13H3a1 1 0 1 1 0-2h1.268A8.001 8.001 0 0 1 11 4.268V3a1 1 0 0 1 1-1Zm-1 6h2v3h3v2h-3v3h-2v-3H8v-2h3V8Z"/>
                    </svg>
                </div>
            </div>
            <h2 class="mt-4 text-3xl font-bold text-cyan-600">{{ $todayShifts->mn ?? 0 }}</h2>
            <p class="mt-2 text-xs text-slate-500">7:00 AM - Next day 7:00 AM</p>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Evening + Night</p>
                <div class="rounded-2xl bg-fuchsia-100 p-2 text-fuchsia-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2a1 1 0 0 1 1 1v1.268A8.001 8.001 0 0 1 19.732 11H21a1 1 0 1 1 0 2h-1.268A8.001 8.001 0 0 1 13 19.732V21a1 1 0 1 1-2 0v-1.268A8.001 8.001 0 0 1 4.268 13H3a1 1 0 1 1 0-2h1.268A8.001 8.001 0 0 1 11 4.268V3a1 1 0 0 1 1-1Zm-1 6h2v3h3v2h-3v3h-2v-3H8v-2h3V8Z"/>
                    </svg>
                </div>
            </div>
            <h2 class="mt-4 text-3xl font-bold text-fuchsia-600">{{ $todayShifts->en ?? 0 }}</h2>
            <p class="mt-2 text-xs text-slate-500">1:00 PM - Next day 7:00 AM</p>
        </div>
    </div>

    {{-- Main content --}}
    <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
        <div class="space-y-4 xl:col-span-2">

            {{-- Weekly details --}}
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
                <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">This Week Schedule</h3>
                        <p class="text-sm text-slate-500">Your upcoming 7-day shift and leave details</p>
                    </div>
                </div>

                {{-- Mobile cards --}}
                <div class="space-y-3 md:hidden">
                    @forelse($weeklySchedules as $item)
                        <div class="rounded-2xl border border-slate-200 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-sm font-bold text-slate-900">
                                        {{ \Carbon\Carbon::parse($item->start_datetime)->format('D, d M Y') }}
                                    </p>
                                    <p class="mt-1 text-sm text-slate-500">
                                        {{ $item->entry_type === 'shift' ? 'Shift' : 'Leave' }}
                                    </p>
                                </div>

                                @if($item->entry_type === 'shift')
                                    @php
                                        $badgeClass = match($item->shiftType?->code) {
                                            'FD' => 'bg-blue-100 text-blue-700',
                                            'EV' => 'bg-amber-100 text-amber-700',
                                            'NG' => 'bg-violet-100 text-violet-700',
                                            'MN' => 'bg-cyan-100 text-cyan-700',
                                            'EN' => 'bg-fuchsia-100 text-fuchsia-700',
                                            default => 'bg-slate-100 text-slate-700',
                                        };
                                    @endphp
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClass }}">
                                        {{ $item->shiftType?->code ?? 'Shift' }}
                                    </span>
                                @else
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                        {{ $item->leaveType?->code ?? 'Leave' }}
                                    </span>
                                @endif
                            </div>

                            <div class="mt-4 space-y-2 text-sm">
                                <p class="font-semibold text-slate-800">
                                    {{ $item->entry_type === 'shift' ? $item->shiftType?->name : $item->leaveType?->name }}
                                </p>
                                <p class="text-slate-600">
                                    {{ \Carbon\Carbon::parse($item->start_datetime)->format('d M Y h:i A') }}
                                    -
                                    {{ \Carbon\Carbon::parse($item->end_datetime)->format('d M Y h:i A') }}
                                </p>
                                <p class="text-slate-500">
                                    {{ $item->notes ?: 'No notes' }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-300 p-6 text-center text-sm text-slate-500">
                            No schedule entries found for this week.
                        </div>
                    @endforelse
                </div>

                {{-- Desktop table --}}
                <div class="hidden overflow-x-auto md:block">
                    <table class="min-w-full">
                        <thead class="bg-slate-50">
                            <tr class="text-left text-sm text-slate-600">
                                <th class="px-4 py-3 font-semibold">Date</th>
                                <th class="px-4 py-3 font-semibold">Type</th>
                                <th class="px-4 py-3 font-semibold">Shift / Leave</th>
                                <th class="px-4 py-3 font-semibold">Start</th>
                                <th class="px-4 py-3 font-semibold">End</th>
                                <th class="px-4 py-3 font-semibold">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                            @forelse($weeklySchedules as $item)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-slate-900">
                                        {{ \Carbon\Carbon::parse($item->start_datetime)->format('D, d M Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($item->entry_type === 'shift')
                                            @php
                                                $badgeClass = match($item->shiftType?->code) {
                                                    'FD' => 'bg-blue-100 text-blue-700',
                                                    'EV' => 'bg-amber-100 text-amber-700',
                                                    'NG' => 'bg-violet-100 text-violet-700',
                                                    'MN' => 'bg-cyan-100 text-cyan-700',
                                                    'EN' => 'bg-fuchsia-100 text-fuchsia-700',
                                                    default => 'bg-slate-100 text-slate-700',
                                                };
                                            @endphp
                                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClass }}">
                                                {{ $item->shiftType?->code ?? 'Shift' }}
                                            </span>
                                        @else
                                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                                {{ $item->leaveType?->code ?? 'Leave' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $item->entry_type === 'shift' ? $item->shiftType?->name : $item->leaveType?->name }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($item->start_datetime)->format('d M Y h:i A') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($item->end_datetime)->format('d M Y h:i A') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $item->notes ?: '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">
                                        No schedule entries found for this week.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Quick actions --}}
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
                <div class="mb-5">
                    <h3 class="text-lg font-semibold text-slate-900">Quick Actions</h3>
                    <p class="text-sm text-slate-500">Fast access to your most-used pages</p>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <a href="{{ route('calendar.index') }}" class="rounded-3xl border border-slate-200 p-5 transition hover:bg-slate-50">
                        <div class="flex items-center gap-3">
                            <div class="rounded-2xl bg-blue-100 p-3 text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 4h-1V2h-2v2H8V2H6v2H5a2 2 0 0 0-2 2v13a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3V6a2 2 0 0 0-2-2Zm0 15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V10h14v9Z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-base font-semibold text-slate-900">Open Calendar</p>
                                <p class="mt-1 text-sm text-slate-500">See all your shifts and leave visually.</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('schedules.create') }}" class="rounded-3xl border border-slate-200 p-5 transition hover:bg-slate-50">
                        <div class="flex items-center gap-3">
                            <div class="rounded-2xl bg-emerald-100 p-3 text-emerald-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 5a1 1 0 0 1 1 1v5h5a1 1 0 1 1 0 2h-5v5a1 1 0 1 1-2 0v-5H6a1 1 0 1 1 0-2h5V6a1 1 0 0 1 1-1Z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-base font-semibold text-slate-900">Add Schedule</p>
                                <p class="mt-1 text-sm text-slate-500">Create a new shift or leave entry.</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('schedules.index') }}" class="rounded-3xl border border-slate-200 p-5 transition hover:bg-slate-50">
                        <div class="flex items-center gap-3">
                            <div class="rounded-2xl bg-amber-100 p-3 text-amber-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M5 3a2 2 0 0 0-2 2v14.5A1.5 1.5 0 0 0 4.5 21H20v-2H5V5h15V3H5Z"/>
                                    <path d="M8 7h8v2H8V7Zm0 4h8v2H8v-2Zm0 4h5v2H8v-2Z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-base font-semibold text-slate-900">My Schedule</p>
                                <p class="mt-1 text-sm text-slate-500">Edit or delete your saved entries.</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('reports.weekly') }}" class="rounded-3xl border border-slate-200 p-5 transition hover:bg-slate-50">
                        <div class="flex items-center gap-3">
                            <div class="rounded-2xl bg-violet-100 p-3 text-violet-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M4 19h16v2H2V3h2v16Zm3-2V9h3v8H7Zm5 0V5h3v12h-3Zm5 0v-6h3v6h-3Z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-base font-semibold text-slate-900">Weekly Report</p>
                                <p class="mt-1 text-sm text-slate-500">Review your weekly totals and leave summary.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>

        {{-- Sidebar --}}
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
            <h3 class="text-lg font-semibold text-slate-900">Shift Rules</h3>
            <p class="mt-1 text-sm text-slate-500">Fixed shift timings used in this app</p>

            <div class="mt-5 space-y-4">
                <div class="rounded-2xl bg-blue-50 p-4">
                    <p class="text-sm font-semibold text-blue-900">Full Day</p>
                    <p class="mt-1 text-sm text-blue-700">07:00 AM - 07:00 PM</p>
                </div>

                <div class="rounded-2xl bg-amber-50 p-4">
                    <p class="text-sm font-semibold text-amber-900">Evening</p>
                    <p class="mt-1 text-sm text-amber-700">01:00 PM - 07:00 PM</p>
                </div>

                <div class="rounded-2xl bg-violet-50 p-4">
                    <p class="text-sm font-semibold text-violet-900">Night</p>
                    <p class="mt-1 text-sm text-violet-700">07:00 PM - Next day 07:00 AM</p>
                </div>

                <div class="rounded-2xl bg-cyan-50 p-4">
                    <p class="text-sm font-semibold text-cyan-900">Morning + Night</p>
                    <p class="mt-1 text-sm text-cyan-700">07:00 AM - Next day 07:00 AM</p>
                </div>

                <div class="rounded-2xl bg-fuchsia-50 p-4">
                    <p class="text-sm font-semibold text-fuchsia-900">Evening + Night</p>
                    <p class="mt-1 text-sm text-fuchsia-700">01:00 PM - Next day 07:00 AM</p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-sm font-semibold text-slate-900">Leave Day</p>
                    <p class="mt-1 text-sm text-slate-700">12:00 AM - Next day 12:00 AM</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection