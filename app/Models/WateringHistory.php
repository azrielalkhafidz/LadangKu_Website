<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WateringHistory extends Model
{
    protected $fillable = [
        'started_at',
        'ended_at',
        'duration_minutes',
        'duration_seconds',
        'volume_liters',
        'status',
        'trigger',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
    ];

    /** Label durasi formatted */
    public function getDurationLabelAttribute(): string
    {
        $m = $this->duration_minutes ?? 0;
        $s = $this->duration_seconds ?? 0;
        return "{$m}m {$s}s";
    }

    /** Badge status */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'success'     => 'SUCCESS',
            'interrupted' => 'INTERRUPTED',
            'running'     => 'RUNNING',
            default       => 'UNKNOWN',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'success'     => 'text-green-600 bg-green-50 border-green-200',
            'interrupted' => 'text-red-600 bg-red-50 border-red-200',
            'running'     => 'text-blue-600 bg-blue-50 border-blue-200',
            default       => 'text-gray-600 bg-gray-50',
        };
    }
}