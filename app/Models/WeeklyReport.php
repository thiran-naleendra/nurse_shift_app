<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeeklyReport extends Model
{
    protected $table = 'weekly_reports';

    protected $fillable = [
        'week_start',
        'week_end',
        'nurse_profile_id',
        'full_day_count',
        'evening_count',
        'night_count',
        'sleeping_day_count',
        'casual_leave_count',
        'vacation_leave_count',
        'day_off_count',
        'ph_count',
        'total_hours',
    ];

    public function nurseProfile(): BelongsTo
    {
        return $this->belongsTo(NurseProfile::class, 'nurse_profile_id');
    }
}