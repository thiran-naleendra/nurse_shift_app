<?php

namespace App\Http\Controllers;

use App\Models\ScheduleEntry;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $nurseProfile = auth()->user()->nurseProfile;

        if (!$nurseProfile) {
            return redirect()->route('profile.index')
                ->with('error', 'Your nurse profile is missing.');
        }

        $today = now()->toDateString();
        $weekStart = now()->startOfWeek()->startOfDay();
        $weekEnd = now()->endOfWeek()->endOfDay();

        $todayShifts = DB::table('schedule_entries as se')
            ->leftJoin('shift_types as st', 'st.id', '=', 'se.shift_type_id')
            ->selectRaw("
        SUM(CASE WHEN st.code = 'FD' THEN 1 ELSE 0 END) as full_day,
        SUM(CASE WHEN st.code = 'EV' THEN 1 ELSE 0 END) as evening,
        SUM(CASE WHEN st.code = 'NG' THEN 1 ELSE 0 END) as night,
        SUM(CASE WHEN st.code = 'MN' THEN 1 ELSE 0 END) as mn,
        SUM(CASE WHEN st.code = 'EN' THEN 1 ELSE 0 END) as en
    ")
            ->where('se.nurse_profile_id', $nurseProfile->id)
            ->where('se.entry_type', 'shift')
            ->whereDate('se.start_datetime', now()->toDateString())
            ->first();

        $todayLeaves = DB::table('schedule_entries')
            ->where('nurse_profile_id', $nurseProfile->id)
            ->where('entry_type', 'leave')
            ->whereDate('start_datetime', $today)
            ->count();

        $weeklySchedules = ScheduleEntry::with(['shiftType', 'leaveType'])
            ->where('nurse_profile_id', $nurseProfile->id)
            ->whereBetween('start_datetime', [$weekStart, $weekEnd])
            ->orderBy('start_datetime')
            ->get();

        return view('dashboard.index', compact(
            'todayShifts',
            'todayLeaves',
            'weeklySchedules'
        ));
    }
}
