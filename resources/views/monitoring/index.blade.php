<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Monitoring — LadangKu</title>
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
                <input type="text" placeholder="Search sensors or locations..."
                    class="pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div class="flex items-center gap-3">
                <button class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg"
                    onclick="document.getElementById('modal-notif').classList.remove('hidden')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </button>
                <a href="{{ url('/settings') }}" class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg flex items-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </a>
                <button onclick="document.getElementById('modal-deploy').classList.remove('hidden')"
                    class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    + Deploy Sensor
                </button>
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto p-6">

            {{-- Page Header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Sensor Analytics</h1>
                    <p class="text-sm text-gray-500">Monitoring real-time environmental data for Greenhouse Block A</p>
                </div>
                <div class="flex items-center gap-2">
                    {{-- Filter --}}
                    <div class="flex items-center gap-2 text-sm border border-gray-200 rounded-lg px-3 py-2 text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Last 7 Days
                    </div>
                    {{-- View toggle --}}
                    <button id="btn-list" onclick="setView('list')"
                        class="p-2 border border-gray-200 rounded-lg text-gray-500 hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                    </button>
                    <button id="btn-grid" onclick="setView('grid')"
                        class="p-2 border border-gray-200 rounded-lg text-gray-500 hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7"/>
                        </svg>
                    </button>
                    {{-- Export --}}
                    <a href="{{ route('monitoring.export') }}"
                        class="flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export Data
                    </a>
                </div>
            </div>

            {{-- CHART + STATUS --}}
            <div class="grid grid-cols-3 gap-4 mb-6">

                {{-- Chart --}}
                <div class="col-span-2 bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <span class="text-sm font-bold text-gray-800">Environmental Comparison</span>
                        </div>
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span class="flex items-center gap-1.5">
                                <span class="w-3 h-0.5 bg-green-600 inline-block rounded"></span>
                                Soil Moisture (%)
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-3 h-0.5 bg-orange-500 inline-block rounded"></span>
                                Temperature (°C)
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-3 h-0.5 bg-blue-500 inline-block rounded"></span>
                                Humidity (%)
                            </span>
                        </div>
                    </div>
                    <div class="h-60">
                        <canvas id="envChart"></canvas>
                    </div>
                </div>

                {{-- Right Cards --}}
                <div class="flex flex-col gap-3">

                    {{-- All Sensors Online --}}
                    <div class="bg-green-700 rounded-xl p-4 text-white">
                        <div class="flex items-center justify-between mb-3">
                            <svg class="w-8 h-8 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                            </svg>
                            <span class="flex items-center gap-1.5 text-xs font-medium bg-green-600 px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 bg-green-300 rounded-full animate-pulse"></span>
                                LIVE SYNCING...
                            </span>
                        </div>
                        <h3 class="text-lg font-bold mb-1">All Sensors Online</h3>
                        <p class="text-sm text-green-200">{{ $totalSensors }} Active nodes transmitting within optimal range.</p>
                    </div>

                    {{-- Anomaly Report --}}
                    <div class="bg-white rounded-xl border border-gray-200 p-4 flex-1">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Anomaly Report</span>
                        </div>
                        @if($anomalyCount == 0)
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            <p class="text-sm text-gray-600">No critical issues detected in the last 24 hours.</p>
                        </div>
                        @else
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                            <p class="text-sm text-red-600">{{ $anomalyCount }} anomaly detected!</p>
                        </div>
                        @endif
                        <a href="{{ url('/history') }}"
                            class="flex items-center gap-1 text-sm text-blue-600 hover:text-blue-700 font-medium">
                            View incident history
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>

                </div>
            </div>

            {{-- STAT CARDS --}}
            <div class="grid grid-cols-4 gap-4 mb-6">

                {{-- Soil Moisture --}}
                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c0 0-6 6.5-6 10.5a6 6 0 0012 0C18 9.5 12 3 12 3z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">OPTIMAL</span>
                    </div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-medium mb-1">Soil Moisture</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $avgSoil ?? '--' }}<span class="text-sm font-normal text-gray-500">% avg</span>
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Target: 60-75%
                        <span class="text-green-600 ml-1">↑ {{ $soilTrend ?? '0' }}%</span>
                    </p>
                </div>

                {{-- Air Temperature --}}
                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">STABLE</span>
                    </div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-medium mb-1">Air Temperature</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $avgTemp ?? '--' }}<span class="text-sm font-normal text-gray-500">°C avg</span>
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Target: 22-28°C
                        <span class="text-orange-500 ml-1">↑ {{ $tempTrend ?? '0' }}°C</span>
                    </p>
                </div>

                {{-- Air Humidity --}}
                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-yellow-600 bg-yellow-50 px-2 py-0.5 rounded-full">WARNING</span>
                    </div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-medium mb-1">Air Humidity</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $avgHumidity ?? '--' }}<span class="text-sm font-normal text-gray-500">% avg</span>
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Target: 40-70%
                        <span class="text-red-500 ml-1">+{{ $humidityTrend ?? '0' }}% vs Normal</span>
                    </p>
                </div>

                {{-- Light Lux --}}
                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m8-9h1M3 12H2m15.364-6.364l.707.707M5.636 18.364l-.707.707m12.728 0l-.707-.707M6.343 5.636l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full">PEAK</span>
                    </div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-medium mb-1">Light Lux</p>
                    <p class="text-2xl font-bold text-gray-900">
                        42.5<span class="text-sm font-normal text-gray-500">k avg</span>
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Target: 25-50k
                        <span class="text-gray-500 ml-1">— No Change</span>
                    </p>
                </div>

            </div>

            {{-- DETAILED DATA LOG --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span class="text-sm font-bold text-gray-800">Detailed Data Log</span>
                    </div>
                    <a href="{{ route('monitoring.export') }}"
                        class="text-xs text-green-600 hover:text-green-700 font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download raw log (.json)
                    </a>
                </div>

                {{-- View: List --}}
                <div id="view-list">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-xs text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                <th class="pb-3 text-left font-semibold">Timestamp</th>
                                <th class="pb-3 text-left font-semibold">Soil Moisture</th>
                                <th class="pb-3 text-left font-semibold">Temperature</th>
                                <th class="pb-3 text-left font-semibold">Humidity</th>
                                <th class="pb-3 text-left font-semibold">Pump</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($logs as $log)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 text-gray-600">{{ $log->created_at->format('M d, Y H:i:s') }}</td>
                                <td class="py-3 font-medium text-gray-800">{{ $log->soil_moisture }}%</td>
                                <td class="py-3 font-medium text-gray-800">{{ $log->temperature }}°C</td>
                                <td class="py-3 font-medium text-gray-800">{{ $log->humidity }}%</td>
                                <td class="py-3">
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-full
                                        {{ $log->pump_status ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $log->pump_status ? 'ON' : 'OFF' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 font-medium">Belum ada data sensor</p>
                                        <p class="text-gray-400 text-xs">Data akan muncul setelah ESP32 mengirim data</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- View: Grid --}}
                <div id="view-grid" class="hidden">
                    <div class="grid grid-cols-3 gap-3">
                        @forelse($logs as $log)
                        <div class="border border-gray-100 rounded-lg p-3 hover:bg-gray-50">
                            <p class="text-xs text-gray-400 mb-2">{{ $log->created_at->format('M d, H:i') }}</p>
                            <div class="grid grid-cols-2 gap-1 text-xs">
                                <span class="text-gray-500">Soil:</span>
                                <span class="font-medium text-green-600">{{ $log->soil_moisture }}%</span>
                                <span class="text-gray-500">Temp:</span>
                                <span class="font-medium text-orange-500">{{ $log->temperature }}°C</span>
                                <span class="text-gray-500">Hum:</span>
                                <span class="font-medium text-blue-500">{{ $log->humidity }}%</span>
                                <span class="text-gray-500">Pump:</span>
                                <span class="font-bold {{ $log->pump_status ? 'text-green-600' : 'text-gray-400' }}">
                                    {{ $log->pump_status ? 'ON' : 'OFF' }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-3 py-12 text-center text-gray-400 text-sm">
                            Belum ada data sensor
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">{{ $logs->links() }}</div>
            </div>

        </main>
    </div>
</div>

{{-- MODAL DEPLOY SENSOR --}}
<div id="modal-deploy" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4 shadow-xl">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-base font-bold text-gray-900">Deploy Sensor Baru</h3>
            <button onclick="document.getElementById('modal-deploy').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Sensor</label>
                <input type="text" placeholder="contoh: Node-02"
                    class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tipe Sensor</label>
                <select class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Soil Moisture + DHT22</option>
                    <option>DHT22 Only</option>
                    <option>Soil Moisture Only</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Lokasi Block</label>
                <input type="text" placeholder="contoh: Block-B"
                    class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                <p class="text-xs text-blue-700 font-medium">📡 Endpoint API untuk ESP32:</p>
                <code class="text-xs text-blue-600 mt-1 block">POST /api/sensor/data</code>
            </div>
        </div>
        <div class="flex gap-3 mt-6">
            <button onclick="document.getElementById('modal-deploy').classList.add('hidden')"
                class="flex-1 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">
                Batal
            </button>
            <button class="flex-1 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                Deploy Sensor
            </button>
        </div>
    </div>
</div>

{{-- MODAL NOTIF --}}
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
                    <p class="text-xs font-semibold text-gray-800">Sensor Berjalan Normal</p>
                    <p class="text-xs text-gray-500 mt-0.5">Semua sensor aktif dan mengirim data</p>
                    <p class="text-xs text-gray-400 mt-1">Baru saja</p>
                </div>
            </div>
            @if($anomalyCount > 0)
            <div class="flex items-start gap-3 p-3 bg-red-50 rounded-lg">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-800">{{ $anomalyCount }} Anomali Terdeteksi!</p>
                    <p class="text-xs text-gray-500 mt-0.5">Cek riwayat untuk detail</p>
                    <p class="text-xs text-gray-400 mt-1">24 jam terakhir</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Chart
    const chartData = @json($chartData);
    const ctx = document.getElementById('envChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.map(d => d.label),
            datasets: [
                {
                    label: 'Soil Moisture (%)',
                    data: chartData.map(d => parseFloat(d.soil_moisture || 0).toFixed(1)),
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(22,163,74,0.08)',
                    borderWidth: 2, fill: true, tension: 0.4,
                    pointRadius: 3, pointHoverRadius: 5,
                },
                {
                    label: 'Temperature (°C)',
                    data: chartData.map(d => parseFloat(d.temperature || 0).toFixed(1)),
                    borderColor: '#f97316',
                    backgroundColor: 'rgba(249,115,22,0.05)',
                    borderWidth: 2, fill: false, tension: 0.4,
                    pointRadius: 3, pointHoverRadius: 5,
                },
                {
                    label: 'Humidity (%)',
                    data: chartData.map(d => parseFloat(d.humidity || 0).toFixed(1)),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.05)',
                    borderWidth: 2, fill: false, tension: 0.4,
                    pointRadius: 3, pointHoverRadius: 5,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    mode: 'index', intersect: false,
                    backgroundColor: '#1f2937', padding: 12,
                    titleColor: '#fff', bodyColor: '#d1d5db',
                }
            },
            scales: {
                y: {
                    min: 0, max: 100,
                    grid: { color: '#f3f4f6' },
                    ticks: { color: '#9ca3af', font: { size: 11 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#9ca3af', font: { size: 11 } }
                }
            }
        }
    });

    // Toggle view list/grid
    function setView(type) {
        if (type === 'list') {
            document.getElementById('view-list').classList.remove('hidden');
            document.getElementById('view-grid').classList.add('hidden');
            document.getElementById('btn-list').classList.add('bg-green-50', 'text-green-700', 'border-green-300');
            document.getElementById('btn-grid').classList.remove('bg-green-50', 'text-green-700', 'border-green-300');
        } else {
            document.getElementById('view-grid').classList.remove('hidden');
            document.getElementById('view-list').classList.add('hidden');
            document.getElementById('btn-grid').classList.add('bg-green-50', 'text-green-700', 'border-green-300');
            document.getElementById('btn-list').classList.remove('bg-green-50', 'text-green-700', 'border-green-300');
        }
    }

    // Tutup modal klik di luar
    ['modal-deploy', 'modal-notif'].forEach(id => {
        document.getElementById(id).addEventListener('click', function(e) {
            if (e.target === this) this.classList.add('hidden');
        });
    });
</script>

</body>
</html>