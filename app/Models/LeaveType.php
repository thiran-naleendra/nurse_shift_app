<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeaveType extends Model
{
    protected $table = 'leave_types';

    protected $fillable = [
        'name',
        'code',
        'color',
    ];

    public function scheduleEntries(): HasMany
    {
        return $this->hasMany(ScheduleEntry::class, 'leave_type_id');
    }
}