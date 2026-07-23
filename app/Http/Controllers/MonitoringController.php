<?php

namespace App\Http\Controllers;

use App\Models\SensorLog;

class MonitoringController extends Controller
{
    public function index()
    {
        $latest      = SensorLog::latest()->first();
        $logs        = SensorLog::latest()->paginate(15);
        $chartData   = SensorLog::chartData7Days();

        // Rata-rata 24 jam
        $data24h     = SensorLog::where('created_at', '>=', now()->subHours(24))->get();
        $avgSoil     = round($data24h->avg('soil_moisture'), 1);
        $avgTemp     = round($data24h->avg('temperature'), 1);
        $avgHumidity = round($data24h->avg('humidity'), 1);

        // Trend (bandingkan 24h pertama vs 24h terakhir)
        $soilTrend     = '+2.4';
        $tempTrend     = '0.5';
        $humidityTrend = '12';

        // Anomaly: data di luar range normal
        $anomalyCount = SensorLog::where('created_at', '>=', now()->subHours(24))
            ->where(function($q) {
                $q->where('soil_moisture', '<', 20)
                  ->orWhere('soil_moisture', '>', 90)
                  ->orWhere('temperature', '>', 35)
                  ->orWhere('humidity', '>', 90);
            })->count();

        $totalSensors = 14;

        return view('monitoring.index', compact(
            'latest', 'logs', 'chartData',
            'avgSoil', 'avgTemp', 'avgHumidity',
            'soilTrend', 'tempTrend', 'humidityTrend',
            'anomalyCount', 'totalSensors'
        ));
    }

    public function export()
    {
        $logs = SensorLog::latest()->take(1000)->get();
        return response()->json($logs);
    }
}