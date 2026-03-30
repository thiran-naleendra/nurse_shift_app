<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ScheduleEntry;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::where('role', 'nurse')->count();

        $activeToday = DB::table('schedule_entries')
            ->whereDate('start_datetime', now()->toDateString())
            ->distinct('nurse_profile_id')
            ->count('nurse_profile_id');

        $totalShiftsToday = DB::table('schedule_entries')
            ->where('entry_type', 'shift')
            ->whereDate('start_datetime', now()->toDateString())
            ->count();

        $totalLeavesToday = DB::table('schedule_entries')
            ->where('entry_type', 'leave')
            ->whereDate('start_datetime', now()->toDateString())
            ->count();

        $recentUsers = User::where('role', 'nurse')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeToday',
            'totalShiftsToday',
            'totalLeavesToday',
            'recentUsers'
        ));
    }

    public function users()
{
    $search = request('search');

    $users = \App\Models\User::with('nurseProfile')
        ->where('role', 'nurse')
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        })
        ->latest()
        ->paginate(15)
        ->withQueryString();

    return view('admin.users.index', compact('users', 'search'));
}

    public function showUser($id)
    {
        $user = User::with([
            'nurseProfile',
            'nurseProfile.scheduleEntries.shiftType',
            'nurseProfile.scheduleEntries.leaveType'
        ])->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }
}