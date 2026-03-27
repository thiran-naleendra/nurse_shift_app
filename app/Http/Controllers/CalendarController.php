<?php

namespace App\Http\Controllers;

use App\Models\ScheduleEntry;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar.index');
    }

    public function events(Request $request)
    {
        $nurseProfile = auth()->user()->nurseProfile;

        if (!$nurseProfile) {
            return response()->json([]);
        }

        $view = $request->get('view', 'dayGridMonth');

        $entries = ScheduleEntry::with(['shiftType', 'leaveType'])
            ->where('nurse_profile_id', $nurseProfile->id)
            ->get();

        $events = $entries->map(function ($entry) use ($view) {
            $isShift = $entry->entry_type === 'shift';

            $title = $isShift
                ? ($entry->shiftType?->name ?? 'Shift')
                : ($entry->leaveType?->name ?? 'Leave');

            $color = $isShift
                ? ($entry->shiftType?->color ?? '#2563eb')
                : ($entry->leaveType?->color ?? '#16a34a');

            $start = Carbon::parse($entry->start_datetime);
            $end = Carbon::parse($entry->end_datetime);

            $base = [
                'id' => $entry->id,
                'title' => $title,
                'color' => $color,
                'extendedProps' => [
                    'entry_type' => $entry->entry_type,
                    'entry_type_label' => ucfirst($entry->entry_type),
                    'notes' => $entry->notes,
                    'display_date' => $start->format('d M Y'),
                    'edit_url' => route('schedules.edit', $entry->id),
                ],
            ];

            if ($view === 'dayGridMonth') {
                return array_merge($base, [
                    'start' => $start->toDateString(),
                    'allDay' => true,
                ]);
            }

            return array_merge($base, [
                'start' => $start->toIso8601String(),
                'end' => $end->toIso8601String(),
                'allDay' => false,
            ]);
        });

        return response()->json($events->values());
    }
}