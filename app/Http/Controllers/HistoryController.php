<?php

namespace App\Http\Controllers;

use App\Models\WateringHistory;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = WateringHistory::latest('started_at');

        if ($request->filled('date')) {
            $query->whereDate('started_at', $request->date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $logs             = $query->paginate(15)->withQueryString();
        $totalSuccess     = WateringHistory::where('status', 'success')->count();
        $totalInterrupted = WateringHistory::where('status', 'interrupted')->count();
        $totalToday       = WateringHistory::whereDate('started_at', today())->count();
        $totalVolume      = round(WateringHistory::sum('volume_liters'), 1);

        return view('history.index', compact(
            'logs',
            'totalSuccess',
            'totalInterrupted',
            'totalToday',
            'totalVolume'
        ));
    }

    public function export()
    {
        $logs = WateringHistory::latest('started_at')->get();
        $csv  = "Tanggal Mulai,Tanggal Selesai,Durasi (menit),Durasi (detik),Volume (Liter),Trigger,Status\n";
        foreach ($logs as $log) {
            $csv .= "{$log->started_at},{$log->ended_at},{$log->duration_minutes},{$log->duration_seconds},{$log->volume_liters},{$log->trigger},{$log->status}\n";
        }
        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="ladangku_history_' . now()->format('Ymd_His') . '.csv"',
        ]);
    }
}