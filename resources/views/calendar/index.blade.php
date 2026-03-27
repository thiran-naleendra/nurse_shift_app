@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Calendar</h1>
            <p class="text-sm text-slate-500">
                View your shifts and leave records in a clean calendar view
            </p>
        </div>

        <a href="{{ route('schedules.create') }}"
           class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow hover:bg-blue-700">
            Add Schedule
        </a>
    </div>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
        <div class="rounded-2xl bg-white p-4 shadow-sm">
            <div class="mb-2 h-3 w-10 rounded-full bg-blue-600"></div>
            <p class="text-sm font-semibold">Full Day</p>
            <p class="text-xs text-gray-500">7 AM - 7 PM</p>
        </div>

        <div class="rounded-2xl bg-white p-4 shadow-sm">
            <div class="mb-2 h-3 w-10 rounded-full bg-amber-500"></div>
            <p class="text-sm font-semibold">Evening</p>
            <p class="text-xs text-gray-500">1 PM - 7 PM</p>
        </div>

        <div class="rounded-2xl bg-white p-4 shadow-sm">
            <div class="mb-2 h-3 w-10 rounded-full bg-violet-600"></div>
            <p class="text-sm font-semibold">Night</p>
            <p class="text-xs text-gray-500">7 PM - 7 AM</p>
        </div>

        <div class="rounded-2xl bg-white p-4 shadow-sm">
            <div class="mb-2 h-3 w-10 rounded-full bg-gray-500"></div>
            <p class="text-sm font-semibold">Sleeping Day</p>
            <p class="text-xs text-gray-500">24 hrs</p>
        </div>

        <div class="rounded-2xl bg-white p-4 shadow-sm">
            <div class="mb-2 h-3 w-10 rounded-full bg-green-600"></div>
            <p class="text-sm font-semibold">Casual Leave</p>
            <p class="text-xs text-gray-500">24 hrs</p>
        </div>

        <div class="rounded-2xl bg-white p-4 shadow-sm">
            <div class="mb-2 h-3 w-10 rounded-full bg-red-500"></div>
            <p class="text-sm font-semibold">Other Leave</p>
            <p class="text-xs text-gray-500">Vacation / PH</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-3xl bg-white shadow-sm">
        <div class="border-b p-4">
            <h2 class="font-semibold text-slate-900">My Calendar</h2>
            <p class="text-sm text-gray-500">Click a date or event to view details</p>
        </div>

        <div class="p-2 sm:p-4">
            <div id="calendar"></div>
        </div>
    </div>
</div>

{{-- Modal --}}
<div id="calendarModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-md rounded-3xl bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b px-6 py-4">
            <h3 id="modalTitle" class="text-lg font-bold text-slate-900">Calendar Details</h3>
            <button type="button" id="closeModalBtn"
                    class="rounded-xl px-3 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100 hover:text-slate-700">
                ✕
            </button>
        </div>

        <div class="space-y-4 px-6 py-5">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Date</p>
                <p id="modalDate" class="mt-1 text-sm text-slate-800">-</p>
            </div>

            <div id="modalTypeWrap">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Type</p>
                <p id="modalType" class="mt-1 text-sm text-slate-800">-</p>
            </div>

            <div id="modalTimeWrap">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Time</p>
                <p id="modalTime" class="mt-1 text-sm text-slate-800">-</p>
            </div>

            <div id="modalNotesWrap" class="hidden">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Notes</p>
                <p id="modalNotes" class="mt-1 text-sm text-slate-800">-</p>
            </div>
        </div>

        <div class="flex flex-col gap-3 border-t px-6 py-4 sm:flex-row sm:justify-end">
            <a href="#" id="addScheduleBtn"
               class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                Add Schedule
            </a>

            <a href="#" id="editScheduleBtn"
               class="hidden inline-flex items-center justify-center rounded-2xl bg-amber-500 px-4 py-3 text-sm font-semibold text-white hover:bg-amber-600">
                Edit Schedule
            </a>

            <button type="button" id="closeModalFooterBtn"
                    class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Close
            </button>
        </div>
    </div>
</div>

<style>
    #calendar {
        min-height: 650px;
    }

    .fc .fc-toolbar {
        flex-wrap: wrap;
        gap: 8px;
    }

    .fc .fc-toolbar-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
    }

    .fc .fc-button {
        border-radius: 10px !important;
        background: #e2e8f0 !important;
        border: none !important;
        color: #0f172a !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        box-shadow: none !important;
    }

    .fc .fc-button:hover {
        background: #cbd5e1 !important;
    }

    .fc .fc-button-active,
    .fc .fc-button-primary:not(:disabled):active {
        background: #2563eb !important;
        color: white !important;
    }

    .fc-event {
        border-radius: 8px !important;
        border: none !important;
        font-size: 12px !important;
        padding: 2px 6px !important;
        cursor: pointer;
    }

    .fc-day-today {
        background: #eff6ff !important;
    }

    @media (max-width: 640px) {
        .fc-toolbar-title {
            font-size: 14px !important;
        }

        .fc .fc-button {
            padding: 5px 8px !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('calendar');
    const modal = document.getElementById('calendarModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalDate = document.getElementById('modalDate');
    const modalType = document.getElementById('modalType');
    const modalTime = document.getElementById('modalTime');
    const modalNotes = document.getElementById('modalNotes');
    const modalNotesWrap = document.getElementById('modalNotesWrap');
    const addScheduleBtn = document.getElementById('addScheduleBtn');
    const editScheduleBtn = document.getElementById('editScheduleBtn');

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function formatDateOnly(dateStr) {
        const d = new Date(dateStr);
        return d.toLocaleDateString([], {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    function formatDateTime(dateStr) {
        const d = new Date(dateStr);
        return d.toLocaleString([], {
            year: 'numeric',
            month: 'short',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    document.getElementById('closeModalBtn').addEventListener('click', closeModal);
    document.getElementById('closeModalFooterBtn').addEventListener('click', closeModal);

    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    let currentView = 'dayGridMonth';

    const calendar = new FullCalendar.Calendar(el, {
        initialView: 'dayGridMonth',
        height: 650,
        dayMaxEventRows: window.innerWidth < 640 ? 2 : 3,
        moreLinkClick: 'popover',

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: window.innerWidth < 640
                ? 'dayGridMonth,timeGridWeek'
                : 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        datesSet: function(info) {
            currentView = info.view.type;
        },

        events: function(fetchInfo, successCallback, failureCallback) {
            fetch(`{{ route('calendar.events') }}?view=${currentView}`, {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to load calendar events');
                }
                return response.json();
            })
            .then(data => successCallback(data))
            .catch(error => {
                console.error('Calendar load error:', error);
                failureCallback(error);
            });
        },

        dateClick: function(info) {
            modalTitle.textContent = 'Selected Date';
            modalDate.textContent = formatDateOnly(info.dateStr);
            modalType.textContent = 'New schedule';
            modalTime.textContent = 'Choose a shift or leave for this date';
            modalNotesWrap.classList.add('hidden');
            editScheduleBtn.classList.add('hidden');

            const addUrl = `{{ route('schedules.create') }}?date=${info.dateStr}`;
            addScheduleBtn.href = addUrl;
            addScheduleBtn.classList.remove('hidden');

            openModal();
        },

        eventClick: function(info) {
            const event = info.event;
            const props = event.extendedProps || {};

            modalTitle.textContent = event.title || 'Schedule Details';
            modalDate.textContent = props.display_date || formatDateOnly(event.startStr);
            modalType.textContent = props.entry_type_label || 'Schedule';

            if (event.start && event.end) {
                modalTime.textContent = `${formatDateTime(event.start)} - ${formatDateTime(event.end)}`;
            } else if (event.start) {
                modalTime.textContent = formatDateTime(event.start);
            } else {
                modalTime.textContent = '-';
            }

            if (props.notes) {
                modalNotes.textContent = props.notes;
                modalNotesWrap.classList.remove('hidden');
            } else {
                modalNotes.textContent = '-';
                modalNotesWrap.classList.add('hidden');
            }

            addScheduleBtn.href = `{{ route('schedules.create') }}?date=${event.startStr.substring(0,10)}`;
            addScheduleBtn.classList.remove('hidden');

            if (props.edit_url) {
                editScheduleBtn.href = props.edit_url;
                editScheduleBtn.classList.remove('hidden');
            } else {
                editScheduleBtn.classList.add('hidden');
            }

            openModal();
        },

        eventDisplay: 'block',

        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: true
        },

        eventContent: function(arg) {
            if (arg.view.type === 'dayGridMonth') {
                return {
                    html: `<div class="truncate font-semibold">${arg.event.title}</div>`
                };
            }
            return true;
        },

        windowResize: function() {
            calendar.setOption('dayMaxEventRows', window.innerWidth < 640 ? 2 : 3);
            calendar.setOption('headerToolbar', {
                left: 'prev,next today',
                center: 'title',
                right: window.innerWidth < 640
                    ? 'dayGridMonth,timeGridWeek'
                    : 'dayGridMonth,timeGridWeek,timeGridDay'
            });
        }
    });

    calendar.render();
});
</script>
@endsection