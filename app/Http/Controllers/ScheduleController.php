<?php

namespace App\Http\Controllers;

use App\Models\ShiftType;
use App\Models\LeaveType;
use App\Models\ScheduleEntry;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index()
    {
        $nurseProfile = auth()->user()->nurseProfile;

        if (!$nurseProfile) {
            return redirect()->route('profile.index')
                ->with('error', 'Your nurse profile is missing.');
        }

        $schedules = ScheduleEntry::with(['shiftType', 'leaveType'])
            ->where('nurse_profile_id', $nurseProfile->id)
            ->latest()
            ->paginate(20);

        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $shiftTypes = ShiftType::all();
        $leaveTypes = LeaveType::all();

        return view('schedules.create', compact('shiftTypes', 'leaveTypes'));
    }

    public function store(Request $request)
    {
        $nurseProfile = auth()->user()->nurseProfile;

        if (!$nurseProfile) {
            return redirect()->route('profile.index')
                ->with('error', 'Your nurse profile is missing.');
        }

        $data = $request->validate([
            'entry_type' => ['required', 'in:shift,leave'],
            'shift_type_id' => ['nullable', 'exists:shift_types,id'],
            'leave_type_id' => ['nullable', 'exists:leave_types,id'],
            'shift_date' => ['nullable', 'date'],
            'leave_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        if ($data['entry_type'] === 'shift') {
            if (empty($data['shift_type_id'])) {
                return back()->withErrors([
                    'shift_type_id' => 'Shift type is required.'
                ])->withInput();
            }

            if (empty($data['shift_date'])) {
                return back()->withErrors([
                    'shift_date' => 'Shift date is required.'
                ])->withInput();
            }

            $shiftType = ShiftType::findOrFail($data['shift_type_id']);
            $shiftDate = Carbon::parse($data['shift_date']);

            [$startDateTime, $endDateTime] = $this->buildFixedShiftDateTimes($shiftType->code, $shiftDate);
        } else {
            if (empty($data['leave_type_id'])) {
                return back()->withErrors([
                    'leave_type_id' => 'Leave type is required.'
                ])->withInput();
            }

            if (empty($data['leave_date'])) {
                return back()->withErrors([
                    'leave_date' => 'Leave date is required.'
                ])->withInput();
            }

            $startDateTime = Carbon::parse($data['leave_date'])->startOfDay();
            $endDateTime = Carbon::parse($data['leave_date'])->copy()->addDay()->startOfDay();
        }

        $overlap = ScheduleEntry::where('nurse_profile_id', $nurseProfile->id)
            ->where(function ($query) use ($startDateTime, $endDateTime) {
                $query->where('start_datetime', '<', $endDateTime->format('Y-m-d H:i:s'))
                      ->where('end_datetime', '>', $startDateTime->format('Y-m-d H:i:s'));
            })
            ->exists();

        if ($overlap) {
            return back()->withErrors([
                'shift_date' => 'You already have a shift or leave in this time range.'
            ])->withInput();
        }

        ScheduleEntry::create([
            'nurse_profile_id' => $nurseProfile->id,
            'entry_type' => $data['entry_type'],
            'shift_type_id' => $data['entry_type'] === 'shift' ? $data['shift_type_id'] : null,
            'leave_type_id' => $data['entry_type'] === 'leave' ? $data['leave_type_id'] : null,
            'start_datetime' => $startDateTime->format('Y-m-d H:i:s'),
            'end_datetime' => $endDateTime->format('Y-m-d H:i:s'),
            'notes' => $data['notes'] ?? null,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule added successfully.');
    }

    public function edit(string $id)
    {
        $nurseProfile = auth()->user()->nurseProfile;

        if (!$nurseProfile) {
            return redirect()->route('profile.index')
                ->with('error', 'Your nurse profile is missing.');
        }

        $schedule = ScheduleEntry::where('nurse_profile_id', $nurseProfile->id)->findOrFail($id);
        $shiftTypes = ShiftType::all();
        $leaveTypes = LeaveType::all();

        return view('schedules.edit', compact('schedule', 'shiftTypes', 'leaveTypes'));
    }

    public function update(Request $request, string $id)
    {
        $nurseProfile = auth()->user()->nurseProfile;

        if (!$nurseProfile) {
            return redirect()->route('profile.index')
                ->with('error', 'Your nurse profile is missing.');
        }

        $schedule = ScheduleEntry::where('nurse_profile_id', $nurseProfile->id)->findOrFail($id);

        $data = $request->validate([
            'entry_type' => ['required', 'in:shift,leave'],
            'shift_type_id' => ['nullable', 'exists:shift_types,id'],
            'leave_type_id' => ['nullable', 'exists:leave_types,id'],
            'shift_date' => ['nullable', 'date'],
            'leave_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        if ($data['entry_type'] === 'shift') {
            if (empty($data['shift_type_id'])) {
                return back()->withErrors([
                    'shift_type_id' => 'Shift type is required.'
                ])->withInput();
            }

            if (empty($data['shift_date'])) {
                return back()->withErrors([
                    'shift_date' => 'Shift date is required.'
                ])->withInput();
            }

            $shiftType = ShiftType::findOrFail($data['shift_type_id']);
            $shiftDate = Carbon::parse($data['shift_date']);

            [$startDateTime, $endDateTime] = $this->buildFixedShiftDateTimes($shiftType->code, $shiftDate);
        } else {
            if (empty($data['leave_type_id'])) {
                return back()->withErrors([
                    'leave_type_id' => 'Leave type is required.'
                ])->withInput();
            }

            if (empty($data['leave_date'])) {
                return back()->withErrors([
                    'leave_date' => 'Leave date is required.'
                ])->withInput();
            }

            $startDateTime = Carbon::parse($data['leave_date'])->startOfDay();
            $endDateTime = Carbon::parse($data['leave_date'])->copy()->addDay()->startOfDay();
        }

        $overlap = ScheduleEntry::where('nurse_profile_id', $nurseProfile->id)
            ->where('id', '!=', $schedule->id)
            ->where(function ($query) use ($startDateTime, $endDateTime) {
                $query->where('start_datetime', '<', $endDateTime->format('Y-m-d H:i:s'))
                      ->where('end_datetime', '>', $startDateTime->format('Y-m-d H:i:s'));
            })
            ->exists();

        if ($overlap) {
            return back()->withErrors([
                'shift_date' => 'You already have a shift or leave in this time range.'
            ])->withInput();
        }

        $schedule->update([
            'entry_type' => $data['entry_type'],
            'shift_type_id' => $data['entry_type'] === 'shift' ? $data['shift_type_id'] : null,
            'leave_type_id' => $data['entry_type'] === 'leave' ? $data['leave_type_id'] : null,
            'start_datetime' => $startDateTime->format('Y-m-d H:i:s'),
            'end_datetime' => $endDateTime->format('Y-m-d H:i:s'),
            'notes' => $data['notes'] ?? null,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(string $id)
    {
        $nurseProfile = auth()->user()->nurseProfile;

        if (!$nurseProfile) {
            return redirect()->route('profile.index')
                ->with('error', 'Your nurse profile is missing.');
        }

        $schedule = ScheduleEntry::where('nurse_profile_id', $nurseProfile->id)->findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }

    private function buildFixedShiftDateTimes(string $shiftCode, Carbon $shiftDate): array
    {
        $start = $shiftDate->copy();
        $end = $shiftDate->copy();

        if ($shiftCode === 'FD') {
            $start->setTime(7, 0, 0);
            $end->setTime(19, 0, 0);
        } elseif ($shiftCode === 'EV') {
            $start->setTime(13, 0, 0);
            $end->setTime(19, 0, 0);
        } elseif ($shiftCode === 'NG') {
            $start->setTime(19, 0, 0);
            $end->addDay()->setTime(7, 0, 0);
        } else {
            $start->setTime(7, 0, 0);
            $end->setTime(19, 0, 0);
        }

        return [$start, $end];
    }
}