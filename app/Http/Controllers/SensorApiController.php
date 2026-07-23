<?php

namespace App\Http\Controllers;

use App\Models\SensorLog;
use App\Models\WateringHistory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SensorApiController extends Controller
{
    /**
     * POST /api/sensor/data
     * ESP32 kirim data ke sini
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'soil_moisture' => 'required|numeric|min:0|max:100',
            'temperature'   => 'required|numeric',
            'humidity'      => 'required|numeric|min:0|max:100',
            'pump_status'   => 'sometimes|boolean',
        ]);

        $last = SensorLog::latest()->first();

        // FIX (revisi ke-2): pump_mode dibaca dari tabel `settings` —
        // ini sekarang SATU-SATUNYA sumber kebenaran, sama dengan yang
        // dipakai halaman Settings dan yang ditulis DashboardController::
        // togglePump(). Sempat saya arahkan ke sensor_logs.pump_mode di
        // revisi sebelumnya, tapi itu sebelum saya tahu halaman Settings
        // sudah punya kontrol mode sendiri yang terpisah.
        $pumpMode    = \App\Models\Setting::get('pump_mode', 'auto');
        $currentPump = $last->pump_status ?? false;

        if ($pumpMode === 'auto') {
            $thresholdLow  = (float) \App\Models\Setting::get('soil_threshold_low', 40);
            $thresholdHigh = (float) \App\Models\Setting::get('soil_threshold_high', 70);

            if ($validated['soil_moisture'] < $thresholdLow) {
                $validated['pump_status'] = true;
            } elseif ($validated['soil_moisture'] > $thresholdHigh) {
                $validated['pump_status'] = false;
            } else {
                $validated['pump_status'] = $currentPump;
            }
        } else {
            // Mode manual: pertahankan status yang sudah diset lewat
            // dashboard, jangan diubah oleh data telemetri ESP32.
            $validated['pump_status'] = $currentPump;
        }

        // Catat watering history
        if ($validated['pump_status'] && !$currentPump) {
            WateringHistory::create([
                'started_at' => now(),
                'status'     => 'running',
                'trigger'    => $pumpMode === 'manual' ? 'manual' : 'auto',
            ]);
        }
        if (!$validated['pump_status'] && $currentPump) {
            $running = WateringHistory::where('status', 'running')->latest()->first();
            if ($running) {
                // FIX: pakai diffInSeconds() + intdiv/modulo, bukan
                // DateInterval->i/->s yang membuang komponen jam untuk
                // sesi penyiraman >= 1 jam.
                $seconds = now()->diffInSeconds($running->started_at);

                $running->update([
                    'ended_at'         => now(),
                    'duration_minutes' => intdiv($seconds, 60),
                    'duration_seconds' => $seconds % 60,
                    'status'           => 'success',
                    'volume_liters'    => round(($seconds / 60) * 0.05, 1),
                ]);
            }
        }

        $log = SensorLog::create([
            'soil_moisture' => $validated['soil_moisture'],
            'temperature'   => $validated['temperature'],
            'humidity'      => $validated['humidity'],
            'pump_status'   => $validated['pump_status'],
            'pump_mode'     => $pumpMode,
        ]);

        return response()->json([
            'success'     => true,
            'pump_status' => $log->pump_status,
            'pump_mode'   => $pumpMode,
        ]);
    }

    /**
     * GET /api/sensor/latest
     * Untuk auto-refresh dashboard
     */
    public function latest(): JsonResponse
    {
        $latest = SensorLog::latest()->first();

        if (!$latest) {
            return response()->json(['success' => false], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'soil_moisture' => $latest->soil_moisture,
                'temperature'   => $latest->temperature,
                'humidity'      => $latest->humidity,
                'pump_status'   => $latest->pump_status,
                'pump_mode'     => \App\Models\Setting::get('pump_mode', 'auto'),
                'updated_at'    => $latest->created_at->format('H:i:s'),
            ]
        ]);
    }
}