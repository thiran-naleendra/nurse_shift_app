@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Weekly Report</h1>
            <p class="text-sm text-slate-500">Your summary from {{ $weekStart }} to {{ $weekEnd }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Full Day</p>
            <h2 class="mt-3 text-3xl font-bold text-blue-600">{{ $report->full_day_count ?? 0 }}</h2>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Evening</p>
            <h2 class="mt-3 text-3xl font-bold text-amber-500">{{ $report->evening_count ?? 0 }}</h2>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Night</p>
            <h2 class="mt-3 text-3xl font-bold text-violet-600">{{ $report->night_count ?? 0 }}</h2>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Hours</p>
            <h2 class="mt-3 text-3xl font-bold text-slate-900">{{ $report->total_hours ?? 0 }}</h2>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Leave</p>
            <h2 class="mt-3 text-3xl font-bold text-green-600">
                {{ ($report->sleeping_day_count ?? 0) + ($report->casual_leave_count ?? 0) + ($report->vacation_leave_count ?? 0) + ($report->day_off_count ?? 0) + ($report->ph_count ?? 0) }}
            </h2>
        </div>
    </div>

    <div class="overflow-hidden rounded-3xl bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4">
            <h3 class="text-lg font-semibold text-slate-900">Leave Summary</h3>
        </div>

        <div class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2 lg:grid-cols-5">
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Sleeping Day</p>
                <p class="mt-2 text-2xl font-bold text-slate-900">{{ $report->sleeping_day_count ?? 0 }}</p>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Casual Leave</p>
                <p class="mt-2 text-2xl font-bold text-slate-900">{{ $report->casual_leave_count ?? 0 }}</p>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Vacation Leave</p>
                <p class="mt-2 text-2xl font-bold text-slate-900">{{ $report->vacation_leave_count ?? 0 }}</p>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Day Off</p>
                <p class="mt-2 text-2xl font-bold text-slate-900">{{ $report->day_off_count ?? 0 }}</p>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">PH</p>
                <p class="mt-2 text-2xl font-bold text-slate-900">{{ $report->ph_count ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>
@endsection