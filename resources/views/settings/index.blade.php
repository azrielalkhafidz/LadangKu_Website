<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Settings — LadangKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                <input type="text" placeholder="Search settings..."
                    class="pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div class="flex items-center gap-2 pl-3 border-l border-gray-200 ml-3">
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
        </header>

        <main class="flex-1 overflow-y-auto p-6">

            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-xl font-bold text-gray-900">Settings</h1>
                <p class="text-sm text-gray-500">Konfigurasi sistem monitoring dan penyiraman otomatis</p>
            </div>

            {{-- Flash --}}
            @if(session('success'))
            <div class="mb-4 flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif

            <div class="grid grid-cols-3 gap-6">

                {{-- Form Settings --}}
                <div class="col-span-2 space-y-4">

                    {{-- Threshold Card --}}
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c0 0-6 6.5-6 10.5a6 6 0 0012 0C18 9.5 12 3 12 3z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-gray-800">Ambang Batas Kelembaban Tanah</h2>
                                <p class="text-xs text-gray-400">Tentukan batas kelembaban untuk mengaktifkan/menonaktifkan pompa</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('settings.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                                        Batas Bawah (%) — Pompa Nyala
                                    </label>
                                    <input type="number" name="soil_threshold_low"
                                        value="{{ $settings['soil_threshold_low'] }}"
                                        min="0" max="100"
                                        class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm
                                               focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <p class="text-xs text-gray-400 mt-1">Pompa menyala jika kelembaban di bawah nilai ini</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                                        Batas Atas (%) — Pompa Mati
                                    </label>
                                    <input type="number" name="soil_threshold_high"
                                        value="{{ $settings['soil_threshold_high'] }}"
                                        min="0" max="100"
                                        class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm
                                               focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <p class="text-xs text-gray-400 mt-1">Pompa mati jika kelembaban di atas nilai ini</p>
                                </div>
                            </div>

                            {{-- Visual range --}}
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <p class="text-xs font-semibold text-gray-600 mb-2">Visualisasi Range</p>
                                <div class="relative h-4 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="absolute h-full bg-red-400 rounded-l-full" style="width: {{ $settings['soil_threshold_low'] }}%"></div>
                                    <div class="absolute h-full bg-green-500"
                                        style="left: {{ $settings['soil_threshold_low'] }}%; width: {{ $settings['soil_threshold_high'] - $settings['soil_threshold_low'] }}%">
                                    </div>
                                    <div class="absolute h-full bg-blue-400 rounded-r-full"
                                        style="left: {{ $settings['soil_threshold_high'] }}%; width: {{ 100 - $settings['soil_threshold_high'] }}%">
                                    </div>
                                </div>
                                <div class="flex justify-between text-xs text-gray-400 mt-1">
                                    <span>0%</span>
                                    <span class="text-red-500">Kering (Pompa ON)</span>
                                    <span class="text-green-600">Optimal</span>
                                    <span class="text-blue-500">Basah (Pompa OFF)</span>
                                    <span>100%</span>
                                </div>
                            </div>

                            {{-- Mode pompa --}}
                            <div class="mb-5">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                                    Mode Penyiraman
                                </label>
                                <div class="flex gap-3">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="pump_mode" value="auto"
                                            {{ $settings['pump_mode'] === 'auto' ? 'checked' : '' }}
                                            class="text-green-600 focus:ring-green-500">
                                        <span class="text-sm text-gray-700 font-medium">Otomatis</span>
                                        <span class="text-xs text-gray-400">(berdasarkan threshold)</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="pump_mode" value="manual"
                                            {{ $settings['pump_mode'] === 'manual' ? 'checked' : '' }}
                                            class="text-green-600 focus:ring-green-500">
                                        <span class="text-sm text-gray-700 font-medium">Manual</span>
                                        <span class="text-xs text-gray-400">(kontrol dari dashboard)</span>
                                    </label>
                                </div>
                            </div>

                            <button type="submit"
                                class="bg-green-700 hover:bg-green-800 text-white font-semibold py-2.5 px-6 rounded-lg
                                       text-sm transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Pengaturan
                            </button>
                        </form>
                    </div>

                    {{-- Interval Sampling --}}
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-gray-800">Interval Pengiriman Data</h2>
                                <p class="text-xs text-gray-400">Seberapa sering ESP32 mengirim data sensor ke server</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                                    Interval (detik)
                                </label>
                                <input type="number" value="30" min="5" max="3600"
                                    class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm
                                           focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    disabled>
                            </div>
                            <div class="pt-5">
                                <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1.5 rounded-lg font-medium">
                                    Dikonfigurasi di ESP32
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Info Panel --}}
                <div class="space-y-4">

                    {{-- Status Sistem --}}
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h3 class="text-sm font-bold text-gray-800 mb-4">Status Sistem</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Mode Pompa</span>
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full
                                    {{ $settings['pump_mode'] === 'auto' ? 'bg-green-100 text-green-700' : 'bg-purple-100 text-purple-700' }}">
                                    {{ strtoupper($settings['pump_mode']) }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Threshold Bawah</span>
                                <span class="text-sm font-bold text-gray-800">{{ $settings['soil_threshold_low'] }}%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Threshold Atas</span>
                                <span class="text-sm font-bold text-gray-800">{{ $settings['soil_threshold_high'] }}%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Database</span>
                                <span class="text-xs font-bold bg-green-100 text-green-700 px-2.5 py-1 rounded-full">CONNECTED</span>
                            </div>
                        </div>
                    </div>

                    {{-- API Info --}}
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h3 class="text-sm font-bold text-gray-800 mb-4">API Endpoint ESP32</h3>
                        <div class="space-y-2">
                            <div>
                                <p class="text-xs text-gray-400 mb-1">POST Data Sensor</p>
                                <code class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded block break-all">
                                    /api/sensor/data
                                </code>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-1">GET Data Terbaru</p>
                                <code class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded block break-all">
                                    /api/sensor/latest
                                </code>
                            </div>
                        </div>
                        <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-xs text-yellow-700">
                                Gunakan IP server Laravel sebagai base URL saat mengkonfigurasi ESP32.
                            </p>
                        </div>
                    </div>

                    {{-- Danger Zone --}}
                    <div class="bg-white rounded-xl border border-red-200 p-5">
                        <h3 class="text-sm font-bold text-red-600 mb-3">Danger Zone</h3>
                        <p class="text-xs text-gray-500 mb-3">
                            Tindakan ini tidak dapat dibatalkan. Pastikan sebelum melanjutkan.
                        </p>
                        <button onclick="confirm('Yakin ingin mereset semua data sensor?')"
                            class="w-full text-sm font-medium text-red-600 border border-red-300 hover:bg-red-50
                                   py-2 px-4 rounded-lg transition-colors">
                            Reset Data Sensor
                        </button>
                    </div>

                </div>
            </div>

        </main>
    </div>
</div>

</body>
</html>