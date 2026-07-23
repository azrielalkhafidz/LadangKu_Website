<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard — LadangKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 font-sans">

<div class="flex h-screen overflow-hidden">

    @include('partials.sidebar')

    <div class="ml-56 flex-1 flex flex-col overflow-hidden">

        {{-- Topbar --}}
        <header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between">
            <div class="relative flex-1 max-w-xs">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" placeholder="Search devices or sensors..."
                    class="pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div class="flex items-center gap-3">
                {{-- Notifikasi --}}
                <button class="relative p-2 text-gray-500 hover:bg-gray-100 rounded-lg"
                    onclick="document.getElementById('modal-notif').classList.remove('hidden')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </button>
                {{-- Settings --}}
                <a href="{{ url('/settings') }}" class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </a>
                {{-- User --}}
                <div class="flex items-center gap-2 pl-3 border-l border-gray-200">
                    <div class="w-8 h-8 rounded-full bg-green-700 flex items-center justify-center">
                        <span class="text-xs font-bold text-white">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-400">Owner Admin</p>
                    </div>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto p-6">

            {{-- Page Header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Farm Overview</h1>
                    <p class="text-sm text-green-600">Real-time telemetry and control for Block-A Irrigation.</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 text-sm text-gray-600 border border-gray-200 rounded-lg px-3 py-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ now()->format('M d, Y') }}
                    </div>
                    <button onclick="document.getElementById('modal-device').classList.remove('hidden')"
                        class="flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        + New Device
                    </button>
                </div>
            </div>

            {{-- STAT CARDS --}}
            <div class="grid grid-cols-4 gap-4 mb-6">

                {{-- Soil Moisture --}}
                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c0 0-6 6.5-6 10.5a6 6 0 0012 0C18 9.5 12 3 12 3z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">
                            {{ $latest ? ($latest->soil_moisture > 40 ? '+2.4%' : 'Low') : 'No Data' }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-medium mb-1">Soil Moisture</p>
                    <p class="text-2xl font-bold text-gray-900" id="soil-value">
                        {{ $latest ? $latest->soil_moisture : '--' }}<span class="text-base font-medium text-gray-500"> %</span>
                    </p>
                    <div class="mt-2 h-1.5 bg-gray-100 rounded-full">
                        <div class="h-1.5 bg-green-500 rounded-full transition-all duration-500"
                             id="soil-bar"
                             style="width: {{ $latest ? min($latest->soil_moisture, 100) : 0 }}%"></div>
                    </div>
                </div>

                {{-- Air Temperature --}}
                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">Optimal</span>
                    </div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-medium mb-1">Air Temperature</p>
                    <p class="text-2xl font-bold text-gray-900" id="temp-value">
                        {{ $latest ? $latest->temperature : '--' }}<span class="text-base font-medium text-gray-500"> °C</span>
                    </p>
                    <div class="mt-2 h-1.5 bg-gray-100 rounded-full">
                        <div class="h-1.5 bg-orange-400 rounded-full transition-all duration-500"
                             id="temp-bar"
                             style="width: {{ $latest ? min(($latest->temperature / 50) * 100, 100) : 0 }}%"></div>
                    </div>
                </div>

                {{-- Air Humidity --}}
                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-red-500 bg-red-50 px-2 py-0.5 rounded-full">-5%</span>
                    </div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-medium mb-1">Air Humidity</p>
                    <p class="text-2xl font-bold text-gray-900" id="humidity-value">
                        {{ $latest ? $latest->humidity : '--' }}<span class="text-base font-medium text-gray-500"> %</span>
                    </p>
                    <div class="mt-2 h-1.5 bg-gray-100 rounded-full">
                        <div class="h-1.5 bg-blue-400 rounded-full transition-all duration-500"
                             id="humidity-bar"
                             style="width: {{ $latest ? min($latest->humidity, 100) : 0 }}%"></div>
                    </div>
                </div>

                {{-- Pump Status --}}
                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">
                            ● Active
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-medium mb-1">Pump Status</p>
                    <div class="flex items-center justify-between mt-1">
                        <p class="text-2xl font-bold text-gray-900" id="pump-label">
                            {{ $latest && $latest->pump_status ? 'RUNNING' : 'STOPPED' }}
                        </p>
                        {{-- Toggle ON/OFF --}}
                        <button id="pump-toggle-btn"
                            onclick="togglePump()"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none
                                {{ $latest && $latest->pump_status ? 'bg-green-600' : 'bg-gray-300' }}">
                            <span id="pump-toggle-dot"
                                class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform
                                    {{ $latest && $latest->pump_status ? 'translate-x-6' : 'translate-x-1' }}">
                            </span>
                        </button>
                    </div>
                    {{-- Mode indicator --}}
                    <p class="text-xs mt-2" id="pump-mode-label">
                        @if(($pumpMode ?? 'auto') === 'auto')
                            <span class="text-blue-500 font-medium">🤖 Mode: Otomatis (ESP32)</span>
                        @else
                            <span class="text-orange-500 font-medium">👆 Mode: Manual (Dashboard)</span>
                        @endif
                    </p>
                </div>

            </div>
            {{-- CHART + STATUS --}}
            <div class="grid grid-cols-3 gap-4 mb-6">

                <div class="col-span-2 bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-sm font-bold text-gray-800">Soil Moisture Monitoring</h2>
                            <p class="text-xs text-gray-400">Real-time data streaming from Node-01</p>
                        </div>
                        <div class="flex gap-1">
                            <button class="text-xs px-2.5 py-1 rounded-md bg-green-700 text-white font-medium">LIVE</button>
                            <button class="text-xs px-2.5 py-1 rounded-md text-gray-500 hover:bg-gray-100">9H</button>
                            <button class="text-xs px-2.5 py-1 rounded-md text-gray-500 hover:bg-gray-100">24H</button>
                        </div>
                    </div>
                    <div class="h-52">
                        <canvas id="soilChart"></canvas>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <div class="bg-white rounded-xl border border-gray-200 p-4">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">Sensor Status</p>
                                <p class="text-xs text-gray-400">Capacitive Moisture V2.0</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <span class="text-xs bg-green-100 text-green-700 font-medium px-2 py-0.5 rounded-full">ACTIVE</span>
                            <span class="text-xs bg-blue-100 text-blue-700 font-medium px-2 py-0.5 rounded-full">CALIBRATED</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-200 p-4">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m2-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">ESP32 Status</p>
                                <p class="text-xs text-gray-400">Gate_01_Controller</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <span class="text-xs bg-green-100 text-green-700 font-medium px-2 py-0.5 rounded-full">CONNECTED</span>
                            <span class="text-xs bg-yellow-100 text-yellow-700 font-medium px-2 py-0.5 rounded-full">LATENCY</span>
                            <span class="text-xs bg-purple-100 text-purple-700 font-medium px-2 py-0.5 rounded-full">8MS</span>
                        </div>
                    </div>

                    <div class="bg-green-800 rounded-xl p-4 flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-4 h-4 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-xs font-bold text-green-300 uppercase tracking-wider">Sustainability Insight</p>
                        </div>
                        <p class="text-sm text-white leading-relaxed">
                            System optimization saved
                            <span class="font-bold text-green-300">{{ $totalWatering * 10 }}L</span>
                            of water in the last 24 hours.
                        </p>
                    </div>
                </div>
            </div>

            {{-- RECENT WATERING HISTORY --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-bold text-gray-800">Recent Watering History</h2>
                    <a href="{{ url('/history') }}" class="text-xs text-green-600 hover:text-green-700 font-medium">View Full Log</a>
                </div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-xs text-gray-400 uppercase tracking-wider border-b border-gray-100">
                            <th class="pb-3 text-left font-semibold">Date & Time</th>
                            <th class="pb-3 text-left font-semibold">Duration</th>
                            <th class="pb-3 text-left font-semibold">Volume (Est)</th>
                            <th class="pb-3 text-left font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($recentWatering as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3">
                                <p class="font-medium text-gray-800">{{ $log->started_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $log->started_at->format('h:i A') }}</p>
                            </td>
                            <td class="py-3">
                                <span class="font-bold text-gray-800">{{ $log->duration_minutes ?? 0 }}m</span>
                                <span class="font-bold text-gray-800"> {{ $log->duration_seconds ?? 0 }}s</span>
                            </td>
                            <td class="py-3">
                                <span class="font-medium {{ ($log->volume_liters ?? 0) > 50 ? 'text-orange-500' : 'text-gray-800' }}">
                                    {{ $log->volume_liters ?? 0 }} Liters
                                </span>
                            </td>
                            <td class="py-3">
                                <span class="text-xs font-bold px-2.5 py-1 rounded-md border {{ $log->status_color }}">
                                    {{ $log->status_badge }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-gray-400 text-sm">
                                Belum ada riwayat penyiraman
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>

{{-- MODAL NEW DEVICE --}}
<div id="modal-device" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4 shadow-xl">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-base font-bold text-gray-900">Tambah Device Baru</h3>
            <button onclick="document.getElementById('modal-device').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Device</label>
                <input type="text" placeholder="contoh: Node-01"
                    class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tipe Sensor</label>
                <select class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option>Soil Moisture + DHT22</option>
                    <option>DHT22 Only</option>
                    <option>Soil Moisture Only</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Lokasi</label>
                <input type="text" placeholder="contoh: Block-A Greenhouse"
                    class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
        </div>
        <div class="flex gap-3 mt-6">
            <button onclick="document.getElementById('modal-device').classList.add('hidden')"
                class="flex-1 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">
                Batal
            </button>
            <button class="flex-1 py-2.5 bg-green-700 text-white text-sm font-medium rounded-lg hover:bg-green-800">
                Tambah Device
            </button>
        </div>
        <p class="text-xs text-gray-400 text-center mt-3">
            * Konfigurasi IP server di Arduino IDE setelah device ditambahkan
        </p>
    </div>
</div>

{{-- MODAL NOTIFIKASI --}}
<div id="modal-notif" class="hidden fixed inset-0 bg-black/50 z-50 flex items-start justify-end p-4">
    <div class="bg-white rounded-2xl w-80 shadow-xl mt-14 mr-2">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h3 class="text-sm font-bold text-gray-900">Notifikasi</h3>
            <button onclick="document.getElementById('modal-notif').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="p-4 space-y-3">
            <div class="flex items-start gap-3 p-3 bg-green-50 rounded-lg">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-800">Sistem Berjalan Normal</p>
                    <p class="text-xs text-gray-500 mt-0.5">Semua sensor aktif dan terhubung</p>
                    <p class="text-xs text-gray-400 mt-1">Baru saja</p>
                </div>
            </div>
            <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-lg">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-800">Data Sensor Diterima</p>
                    <p class="text-xs text-gray-500 mt-0.5">ESP32 mengirim data terbaru</p>
                    <p class="text-xs text-gray-400 mt-1">2 menit lalu</p>
                </div>
            </div>
            @if(!$latest)
            <div class="flex items-start gap-3 p-3 bg-yellow-50 rounded-lg">
                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-800">Belum Ada Data Sensor</p>
                    <p class="text-xs text-gray-500 mt-0.5">Hubungkan ESP32 ke server</p>
                    <p class="text-xs text-gray-400 mt-1">Sekarang</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>

    const chartData = @json($chartData);

    const labels = chartData.map(d => d.label);
    const soilData = chartData.map(d => parseFloat(d.soil_moisture || 0));

    const ctx = document.getElementById('soilChart').getContext('2d');

    const soilChart = new Chart(ctx, {

        type: 'line',

        data: {

            labels: labels.length ? labels : ['--'],

            datasets: [{

                label: 'Soil Moisture (%)',

                data: soilData.length ? soilData : [0],

                borderColor: '#15803d',

                backgroundColor: 'rgba(21,128,61,.1)',

                borderWidth: 2.5,

                fill: true,

                tension: .4,

                pointRadius: 4,

                pointHoverRadius: 6

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: { display:false },

                tooltip: {

                    backgroundColor:'#15803d',

                    callbacks:{

                        label:ctx=>ctx.parsed.y+'%'

                    }

                }

            },

            scales:{

                y:{

                    min:0,

                    max:100,

                    ticks:{

                        callback:v=>v+'%'

                    }

                }

            }

        }

    });


    // ===== TOGGLE PUMP =====
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let isPumpOn = {{ $latest && $latest->pump_status ? 'true' : 'false' }};

    async function togglePump() {
        try {
            const res = await fetch('/dashboard/toggle-pump', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ status: !isPumpOn })
            });
            const json = await res.json();
            if (!json.success) return;

            isPumpOn = json.pump_status;
            updatePumpUI(isPumpOn);

        } catch (e) {
            console.error('[PUMP] Error:', e);
            alert('Gagal mengubah status pompa. Cek koneksi server.');
        }
    }

    function updatePumpUI(status) {
        const label  = document.getElementById('pump-label');
        const btn    = document.getElementById('pump-toggle-btn');
        const dot    = document.getElementById('pump-toggle-dot');

        if (label) label.textContent = status ? 'RUNNING' : 'STOPPED';

        if (btn) {
            btn.className = `relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none ${
                status ? 'bg-green-600' : 'bg-gray-300'
            }`;
        }
        if (dot) {
            dot.className = `inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform ${
                status ? 'translate-x-6' : 'translate-x-1'
            }`;
        }
    }


    // ===============================
    // AUTO REFRESH
    // ===============================

    setInterval(async()=>{

    try{

    const res=await fetch('/api/sensor/latest');

    const json=await res.json();

    if(!json.success) return;

    const d=json.data;

    document.getElementById('soil-value').innerHTML=
    `${d.soil_moisture}<span class="text-base font-medium text-gray-500"> %</span>`;

    document.getElementById('temp-value').innerHTML=
    `${d.temperature}<span class="text-base font-medium text-gray-500"> °C</span>`;

    document.getElementById('humidity-value').innerHTML=
    `${d.humidity}<span class="text-base font-medium text-gray-500"> %</span>`;

    document.getElementById('soil-bar').style.width=
    d.soil_moisture+'%';

    document.getElementById('temp-bar').style.width=
    (d.temperature/50*100)+'%';

    document.getElementById('humidity-bar').style.width=
    d.humidity+'%';

    // update chart

    const now=new Date().toLocaleTimeString(
    'id-ID',
    {
    hour:'2-digit',
    minute:'2-digit'
    }
    );

    soilChart.data.labels.push(now);

    soilChart.data.datasets[0].data.push(d.soil_moisture);

    if(soilChart.data.labels.length>20){

    soilChart.data.labels.shift();

    soilChart.data.datasets[0].data.shift();

    }

    soilChart.update("none");

    }catch(e){

    console.log(e);

    }

    },3000);


    // ===============================
    // MODAL
    // ===============================
    document.getElementById('modal-device')
    .addEventListener('click',function(e){

    if(e.target===this){

    this.classList.add('hidden');

    }

    });

    document.getElementById('modal-notif')
    .addEventListener('click',function(e){

    if(e.target===this){

    this.classList.add('hidden');

    }

    });

</script>

</body>
</html>