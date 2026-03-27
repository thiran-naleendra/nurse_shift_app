@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">My Schedule</h1>
            <p class="text-sm text-slate-500">Manage your own shifts and leave records</p>
        </div>

        <a href="{{ route('schedules.create') }}"
           class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
            Add Schedule
        </a>
    </div>

    {{-- Mobile view --}}
    <div class="space-y-4 md:hidden">
        @forelse($schedules as $schedule)
            <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-100">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        @if($schedule->entry_type === 'shift')
                            <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                Shift
                            </span>
                        @else
                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                Leave
                            </span>
                        @endif

                        <h3 class="mt-3 text-base font-bold text-slate-900">
                            {{ $schedule->entry_type === 'shift' ? $schedule->shiftType?->name : $schedule->leaveType?->name }}
                        </h3>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-1 gap-3 text-sm">
                    <div class="rounded-2xl bg-slate-50 p-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Start</p>
                        <p class="mt-1 font-medium text-slate-900">
                            {{ \Carbon\Carbon::parse($schedule->start_datetime)->format('d M Y h:i A') }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">End</p>
                        <p class="mt-1 font-medium text-slate-900">
                            {{ \Carbon\Carbon::parse($schedule->end_datetime)->format('d M Y h:i A') }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Notes</p>
                        <p class="mt-1 break-words font-medium text-slate-900">
                            {{ $schedule->notes ?: '-' }}
                        </p>
                    </div>
                </div>

                <div class="mt-5 flex flex-col gap-2 sm:flex-row">
                    <a href="{{ route('schedules.edit', $schedule->id) }}"
                       class="inline-flex items-center justify-center rounded-2xl bg-amber-100 px-4 py-2.5 text-sm font-semibold text-amber-700 hover:bg-amber-200">
                        Edit
                    </a>

                    <form method="POST"
                          action="{{ route('schedules.destroy', $schedule->id) }}"
                          onsubmit="return confirm('Delete this schedule?')"
                          class="w-full sm:w-auto">
                        @csrf
                        @method('DELETE')
                        <button class="w-full rounded-2xl bg-red-100 px-4 py-2.5 text-sm font-semibold text-red-700 hover:bg-red-200">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="rounded-3xl bg-white p-10 text-center text-sm text-slate-500 shadow-sm ring-1 ring-slate-100">
                No schedule records found.
            </div>
        @endforelse
    </div>

    {{-- Desktop view --}}
    <div class="hidden overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-100 md:block">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-50">
                    <tr class="text-left text-sm text-slate-600">
                        <th class="px-6 py-4 font-semibold">Type</th>
                        <th class="px-6 py-4 font-semibold">Shift / Leave</th>
                        <th class="px-6 py-4 font-semibold">Start</th>
                        <th class="px-6 py-4 font-semibold">End</th>
                        <th class="px-6 py-4 font-semibold">Notes</th>
                        <th class="px-6 py-4 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($schedules as $schedule)
                        <tr>
                            <td class="px-6 py-4">
                                @if($schedule->entry_type === 'shift')
                                    <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                        Shift
                                    </span>
                                @else
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                        Leave
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 font-medium text-slate-900">
                                {{ $schedule->entry_type === 'shift' ? $schedule->shiftType?->name : $schedule->leaveType?->name }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($schedule->start_datetime)->format('d M Y h:i A') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($schedule->end_datetime)->format('d M Y h:i A') }}
                            </td>

                            <td class="px-6 py-4 max-w-xs">
                                <div class="truncate" title="{{ $schedule->notes }}">
                                    {{ $schedule->notes ?: '-' }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('schedules.edit', $schedule->id) }}"
                                       class="rounded-xl bg-amber-100 px-3 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-200">
                                        Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('schedules.destroy', $schedule->id) }}"
                                          onsubmit="return confirm('Delete this schedule?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-xl bg-red-100 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-200">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-slate-500">
                                No schedule records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        {{ $schedules->links() }}
    </div>
</div>
@endsection