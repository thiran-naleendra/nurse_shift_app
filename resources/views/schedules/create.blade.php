@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-4xl">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Add Schedule</h1>
            <p class="text-sm text-slate-500">Add your own shift or leave record</p>
        </div>

        <a href="{{ route('schedules.index') }}"
           class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
            Back
        </a>
    </div>

    <div class="rounded-3xl bg-white p-6 shadow-lg sm:p-8">
        <form method="POST" action="{{ route('schedules.store') }}" class="grid grid-cols-1 gap-5 md:grid-cols-2">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Entry Type</label>
                <select name="entry_type" id="entry_type"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                    <option value="shift" {{ old('entry_type') == 'shift' ? 'selected' : '' }}>Shift</option>
                    <option value="leave" {{ old('entry_type') == 'leave' ? 'selected' : '' }}>Leave</option>
                </select>
            </div>

            <div id="shift_type_box">
                <label class="mb-2 block text-sm font-medium text-slate-700">Shift Type</label>
                <select name="shift_type_id" id="shift_type_id"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                    <option value="">Select Shift</option>
                    @foreach($shiftTypes as $shift)
                        <option value="{{ $shift->id }}"
                                data-code="{{ $shift->code }}"
                                {{ old('shift_type_id') == $shift->id ? 'selected' : '' }}>
                            {{ $shift->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="leave_type_box">
                <label class="mb-2 block text-sm font-medium text-slate-700">Leave Type</label>
                <select name="leave_type_id"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                    <option value="">Select Leave</option>
                    @foreach($leaveTypes as $leave)
                        <option value="{{ $leave->id }}" {{ old('leave_type_id') == $leave->id ? 'selected' : '' }}>
                            {{ $leave->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="shift_date_box">
                <label class="mb-2 block text-sm font-medium text-slate-700">Shift Date</label>
                <input type="date"
                       id="shift_date"
                       name="shift_date"
                       value="{{ old('shift_date') }}"
                       class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
            </div>

            <div id="leave_date_box">
                <label class="mb-2 block text-sm font-medium text-slate-700">Leave Date</label>
                <input type="date"
                       id="leave_date"
                       name="leave_date"
                       value="{{ old('leave_date') }}"
                       class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
            </div>

            <div class="md:col-span-2 rounded-2xl bg-slate-50 p-4">
                <p class="text-sm font-medium text-slate-700">Preview</p>
                <p class="mt-2 text-sm text-slate-500" id="preview_text">Select entry details to preview schedule time.</p>
            </div>

            <div class="md:col-span-2">
                <label class="mb-2 block text-sm font-medium text-slate-700">Notes</label>
                <textarea name="notes" rows="4"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100">{{ old('notes') }}</textarea>
            </div>

            <div class="md:col-span-2 pt-2">
                <button class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                    Save Schedule
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function formatPreview(dateObj) {
        return dateObj.toLocaleString([], {
            year: 'numeric',
            month: 'short',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function updateShiftPreview() {
        const shiftDate = document.getElementById('shift_date').value;
        const shiftType = document.getElementById('shift_type_id');
        const selected = shiftType.options[shiftType.selectedIndex];
        const code = selected ? selected.getAttribute('data-code') : null;

        if (!shiftDate || !code) {
            document.getElementById('preview_text').innerText = 'Select entry details to preview schedule time.';
            return;
        }

        const start = new Date(shiftDate + 'T00:00:00');
        const end = new Date(shiftDate + 'T00:00:00');

        if (code === 'FD') {
            start.setHours(7, 0, 0, 0);
            end.setHours(19, 0, 0, 0);
        } else if (code === 'EV') {
            start.setHours(13, 0, 0, 0);
            end.setHours(19, 0, 0, 0);
        } else if (code === 'NG') {
            start.setHours(19, 0, 0, 0);
            end.setDate(end.getDate() + 1);
            end.setHours(7, 0, 0, 0);
        }

        document.getElementById('preview_text').innerText =
            `Start: ${formatPreview(start)} | End: ${formatPreview(end)}`;
    }

    function updateLeavePreview() {
        const leaveDate = document.getElementById('leave_date').value;

        if (!leaveDate) {
            document.getElementById('preview_text').innerText = 'Select entry details to preview schedule time.';
            return;
        }

        const start = new Date(leaveDate + 'T00:00:00');
        const end = new Date(leaveDate + 'T00:00:00');
        end.setDate(end.getDate() + 1);

        document.getElementById('preview_text').innerText =
            `Leave: ${formatPreview(start)} to ${formatPreview(end)}`;
    }

    function toggleEntryTypeFields() {
        const entryType = document.getElementById('entry_type').value;

        const shiftTypeBox = document.getElementById('shift_type_box');
        const leaveTypeBox = document.getElementById('leave_type_box');
        const shiftDateBox = document.getElementById('shift_date_box');
        const leaveDateBox = document.getElementById('leave_date_box');

        if (entryType === 'shift') {
            shiftTypeBox.style.display = 'block';
            shiftDateBox.style.display = 'block';
            leaveTypeBox.style.display = 'none';
            leaveDateBox.style.display = 'none';
            updateShiftPreview();
        } else {
            shiftTypeBox.style.display = 'none';
            shiftDateBox.style.display = 'none';
            leaveTypeBox.style.display = 'block';
            leaveDateBox.style.display = 'block';
            updateLeavePreview();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        toggleEntryTypeFields();

        document.getElementById('entry_type').addEventListener('change', toggleEntryTypeFields);
        document.getElementById('shift_type_id').addEventListener('change', updateShiftPreview);
        document.getElementById('shift_date').addEventListener('change', updateShiftPreview);
        document.getElementById('leave_date').addEventListener('change', updateLeavePreview);
    });
</script>
@endsection