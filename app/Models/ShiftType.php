<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShiftType extends Model
{
    protected $table = 'shift_types';

    protected $fillable = [
        'name',
        'code',
        'start_time',
        'end_time',
        'crosses_midnight',
        'color',
    ];

    protected $casts = [
        'crosses_midnight' => 'boolean',
    ];

    public function scheduleEntries(): HasMany
    {
        return $this->hasMany(ScheduleEntry::class, 'shift_type_id');
    }
}