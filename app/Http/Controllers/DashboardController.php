<?php

namespace App\Http\Controllers;

use App\Models\NurseProfile;
use App\Models\ScheduleEntry;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalNurses = NurseProfile::where('status', 'active')->count();

        $todayShifts = ScheduleEntry::select(
                DB::raw("SUM(CASE WHEN shift_type_id = 1 THEN 1 ELSE 0 END) as full_day"),
                DB::raw("SUM(CASE WHEN shift_type_id = 2 THEN 1 ELSE 0 END) as evening"),
                DB::raw("SUM(CASE WHEN shift_type_id = 3 THEN 1 ELSE 0 END) as night")
            )
            ->where('entry_type', 'shift')
            ->whereDate('start_datetime', now()->toDateString())
            ->first();

        $todayLeaves = ScheduleEntry::where('entry_type', 'leave')
            ->whereDate('start_datetime', now()->toDateString())
            ->count();

        return view('dashboard.index', compact('totalNurses', 'todayShifts', 'todayLeaves'));
    }
}