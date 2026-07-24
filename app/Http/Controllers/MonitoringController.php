<?php

namespace App\Http\Controllers;

use App\Models\SensorLog;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    /**
     * Export data sensor sebagai file CSV yang bisa langsung di-download,
     * bukan lagi menampilkan JSON mentah di browser.
     */
    public function export(): StreamedResponse
    {
        $logs = SensorLog::latest()->take(1000)->get();

        $filename = 'monitoring-data-' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($logs) {
            $output = fopen('php://output', 'w');

            // Header kolom
            fputcsv($output, [
                'ID',
                'Soil Moisture (%)',
                'Temperature (°C)',
                'Humidity (%)',
                'Pump Status',
                'Pump Mode',
                'Waktu (Created At)',
            ]);

            foreach ($logs as $log) {
                fputcsv($output, [
                    $log->id,
                    $log->soil_moisture,
                    $log->temperature,
                    $log->humidity,
                    $log->pump_status ? 'ON' : 'OFF',
                    $log->pump_mode ?? '-',
                    $log->created_at,
                ]);
            }

            fclose($output);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}