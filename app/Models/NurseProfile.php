<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NurseProfile extends Model
{
    protected $table = 'nurse_profiles';

    protected $fillable = [
        'user_id',
        'employee_code',
        'department',
        'designation',
        'gender',
        'join_date',
        'status',
        'address',
        'emergency_contact_name',
        'emergency_contact_phone',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scheduleEntries(): HasMany
    {
        return $this->hasMany(ScheduleEntry::class, 'nurse_profile_id');
    }

    public function weeklyReports(): HasMany
    {
        return $this->hasMany(WeeklyReport::class, 'nurse_profile_id');
    }
}