<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function weekly()
    {
        $nurseProfile = auth()->user()->nurseProfile;
        $weekStart = now()->startOfWeek()->toDateString();
        $weekEnd = now()->endOfWeek()->toDateString();

        $report = DB::select("
            SELECT
                SUM(CASE WHEN st.code = 'FD' THEN 1 ELSE 0 END) AS full_day_count,
                SUM(CASE WHEN st.code = 'EV' THEN 1 ELSE 0 END) AS evening_count,
                SUM(CASE WHEN st.code = 'NG' THEN 1 ELSE 0 END) AS night_count,
                SUM(CASE WHEN lt.code = 'SD' THEN 1 ELSE 0 END) AS sleeping_day_count,
                SUM(CASE WHEN lt.code = 'CL' THEN 1 ELSE 0 END) AS casual_leave_count,
                SUM(CASE WHEN lt.code = 'VL' THEN 1 ELSE 0 END) AS vacation_leave_count,
                SUM(CASE WHEN lt.code = 'DO' THEN 1 ELSE 0 END) AS day_off_count,
                SUM(CASE WHEN lt.code = 'PH' THEN 1 ELSE 0 END) AS ph_count,
                SUM(
                    CASE
                        WHEN se.entry_type = 'shift'
                        THEN TIMESTAMPDIFF(MINUTE, se.start_datetime, se.end_datetime) / 60
                        ELSE 0
                    END
                ) AS total_hours
            FROM schedule_entries se
            LEFT JOIN shift_types st ON st.id = se.shift_type_id
            LEFT JOIN leave_types lt ON lt.id = se.leave_type_id
            WHERE se.nurse_profile_id = ?
              AND DATE(se.start_datetime) >= ?
              AND DATE(se.end_datetime) <= ?
        ", [$nurseProfile->id, $weekStart, $weekEnd]);

        return view('reports.weekly', [
            'report' => $report[0] ?? null,
            'weekStart' => $weekStart,
            'weekEnd' => $weekEnd,
        ]);
    }
}