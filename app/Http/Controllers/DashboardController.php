<?php

namespace App\Http\Controllers;

use App\Models\SensorLog;
use Illuminate\Http\Request;
use App\Models\WateringHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Throwable;

class DashboardController extends Controller
{
    public function index()
    {
        $latest         = SensorLog::latest()->first();
        $chartData      = SensorLog::chartData();
        $recentWatering = WateringHistory::latest()->take(5)->get();
        $totalWatering  = WateringHistory::whereDate('created_at', today())->count();

        // FIX: pump_mode sekarang SATU-SATUNYA sumber kebenaran ada di
        // tabel `settings` (sama seperti yang dipakai halaman Settings),
        // bukan lagi kolom sensor_logs.pump_mode — supaya Dashboard dan
        // Settings selalu menampilkan mode yang sama persis.
        $pumpMode = \App\Models\Setting::get('pump_mode', 'auto');

        return view('dashboard.index', compact(
            'latest',
            'chartData',
            'recentWatering',
            'totalWatering',
            'pumpMode'
        ));
    }

    public function togglePump(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'status' => 'sometimes|boolean',
            ]);

            return DB::transaction(function () use ($validated) {
                $last = SensorLog::latest()->first();

                $newStatus = array_key_exists('status', $validated)
                    ? (bool) $validated['status']
                    : !($last?->pump_status ?? false);

                SensorLog::create([
                    'soil_moisture' => $last?->soil_moisture,
                    'temperature'   => $last?->temperature,
                    'humidity'      => $last?->humidity,
                    'pump_status'   => $newStatus,
                    'pump_mode'     => 'manual',
                ]);

                // FIX: tulis mode ke tabel `settings` juga — tempat yang
                // sama dipakai halaman Settings — supaya keduanya selalu
                // sinkron. Sebelumnya cuma ditulis ke kolom sensor_logs
                // (sekadar catatan historis), tidak pernah ke `settings`,
                // sehingga halaman Settings tidak pernah tahu mode sudah
                // berubah jadi manual.
                \App\Models\Setting::set(
                    'pump_mode',
                    'manual',
                    'Mode penyiraman'
                );

                $this->recordWateringTransition($newStatus);

                return response()->json([
                    'success'     => true,
                    'pump_status' => $newStatus,
                    'pump_mode'   => 'manual',
                ]);
            });
        } catch (Throwable $e) {
            Log::error('Gagal toggle pompa: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengubah status pompa',
            ], 500);
        }
    }

    /**
     * Catat transisi ON/OFF pompa ke tabel watering_histories.
     */
    private function recordWateringTransition(bool $pumpTurnedOn): void
    {
        if ($pumpTurnedOn) {
            WateringHistory::create([
                'started_at' => now(),
                'status'     => 'running',
                'trigger'    => 'manual',
            ]);
            return;
        }

        $running = WateringHistory::where('status', 'running')->latest()->first();

        if (!$running) {
            return;
        }

        // FIX: pakai diffInSeconds() + intdiv/modulo, bukan DateInterval->i/->s
        // yang membuang komponen jam untuk sesi penyiraman >= 1 jam.
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