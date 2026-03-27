<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleEntry extends Model
{
    protected $table = 'schedule_entries';

    protected $fillable = [
        'nurse_profile_id',
        'entry_type',
        'shift_type_id',
        'leave_type_id',
        'start_datetime',
        'end_datetime',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
    ];

    public function nurseProfile(): BelongsTo
    {
        return $this->belongsTo(NurseProfile::class, 'nurse_profile_id');
    }

    public function shiftType(): BelongsTo
    {
        return $this->belongsTo(ShiftType::class, 'shift_type_id');
    }

    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}