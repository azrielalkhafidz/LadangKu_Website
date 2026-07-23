<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorLog extends Model
{
    protected $fillable = [
        'soil_moisture',
        'temperature',
        'humidity',
        'pump_status',
        'pump_mode',
    ];

    protected $casts = [
        'pump_status' => 'boolean',
        'soil_moisture' => 'float',
        'temperature'   => 'float',
        'humidity'      => 'float',
    ];

    /** Ambil data terbaru */
    public static function latest_reading(): ?self
    {
        return static::latest()->first();
    }

    /** Data untuk chart (24 jam terakhir, per jam) */
    public static function chartData(): array
    {
        return static::where('created_at', '>=', now()->subHours(24))
            ->selectRaw("DATE_FORMAT(created_at, '%H:00') as label,
                        AVG(soil_moisture) as soil_moisture,
                        AVG(temperature) as temperature,
                        AVG(humidity) as humidity")
            ->groupByRaw("DATE_FORMAT(created_at, '%H:00')")
            ->orderByRaw("MIN(created_at)")
            ->get()
            ->toArray();
    }

    public static function chartData7Days(): array
    {
        return static::where('created_at', '>=', now()->subDays(7))
            ->selectRaw("DATE_FORMAT(created_at, '%a') as label,
                        AVG(soil_moisture) as soil_moisture,
                        AVG(temperature) as temperature,
                        AVG(humidity) as humidity")
            ->groupByRaw("DATE(created_at)")
            ->orderByRaw("DATE(created_at)")
            ->get()
            ->toArray();
    }
}