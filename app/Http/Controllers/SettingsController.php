<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'soil_threshold_low'  => Setting::get('soil_threshold_low', 40),
            'soil_threshold_high' => Setting::get('soil_threshold_high', 70),
            'pump_mode'           => Setting::get('pump_mode', 'auto'),
        ];

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'soil_threshold_low'  => 'required|numeric|min:0|max:100',
            'soil_threshold_high' => 'required|numeric|min:0|max:100|gt:soil_threshold_low',
            'pump_mode'           => 'required|in:auto,manual',
        ]);

        Setting::set('soil_threshold_low',  $request->soil_threshold_low,  'Ambang batas bawah kelembaban tanah');
        Setting::set('soil_threshold_high', $request->soil_threshold_high, 'Ambang batas atas kelembaban tanah');
        Setting::set('pump_mode',           $request->pump_mode,           'Mode penyiraman');

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}