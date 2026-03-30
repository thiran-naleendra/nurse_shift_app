<?php

namespace App\Http\Controllers;

use App\Models\ScheduleEntry;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function weekly()
    {
        $nurseProfile = auth()->user()->nurseProfile;

        if (!$nurseProfile) {
            return redirect()->route('profile.index')
                ->with('error', 'Your nurse profile is missing.');
        }

        $weekStart = now()->startOfWeek()->format('d M Y');
        $weekEnd = now()->endOfWeek()->format('d M Y');

        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $entries = ScheduleEntry::with(['shiftType', 'leaveType'])
            ->where('nurse_profile_id', $nurseProfile->id)
            ->where(function ($query) use ($startOfWeek, $endOfWeek) {
                $query->whereBetween('start_datetime', [$startOfWeek, $endOfWeek])
                      ->orWhereBetween('end_datetime', [$startOfWeek, $endOfWeek]);
            })
            ->get();

        $report = (object) [
            'full_day_count' => 0,
            'evening_count' => 0,
            'night_count' => 0,
            'morning_night_count' => 0,
            'evening_night_count' => 0,
            'sleeping_day_count' => 0,
            'casual_leave_count' => 0,
            'vacation_leave_count' => 0,
            'day_off_count' => 0,
            'ph_count' => 0,
            'total_hours' => 0,
        ];

        foreach ($entries as $entry) {
            if ($entry->entry_type === 'shift') {
                $code = $entry->shiftType?->code;

                if ($code === 'FD') {
                    $report->full_day_count++;
                } elseif ($code === 'EV') {
                    $report->evening_count++;
                } elseif ($code === 'NG') {
                    $report->night_count++;
                } elseif ($code === 'MN') {
                    $report->morning_night_count++;
                } elseif ($code === 'EN') {
                    $report->evening_night_count++;
                }

                $hours = Carbon::parse($entry->start_datetime)
                    ->diffInMinutes(Carbon::parse($entry->end_datetime)) / 60;

                $report->total_hours = round($report->total_hours + $hours, 1);
            }

            if ($entry->entry_type === 'leave') {
                $code = $entry->leaveType?->code;

                if ($code === 'SD') {
                    $report->sleeping_day_count++;
                } elseif ($code === 'CL') {
                    $report->casual_leave_count++;
                } elseif ($code === 'VL') {
                    $report->vacation_leave_count++;
                } elseif ($code === 'DO') {
                    $report->day_off_count++;
                } elseif ($code === 'PH') {
                    $report->ph_count++;
                }
            }
        }

        return view('reports.weekly', compact('report', 'weekStart', 'weekEnd'));
    }
}