<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>History — LadangKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans">

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    @include('partials.sidebar')

    {{-- MAIN --}}
    <div class="ml-56 flex-1 flex flex-col overflow-hidden">

        {{-- Topbar --}}
        <header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between">
            <div class="relative flex-1 max-w-xs">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" placeholder="Search history..."
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
                    <h1 class="text-xl font-bold text-gray-900">Watering History</h1>
                    <p class="text-sm text-gray-500">Riwayat lengkap penyiraman otomatis dan manual</p>
                </div>
                <div class="flex items-center gap-2">
                    {{-- Filter tanggal --}}
                    <form method="GET" action="{{ route('history.index') }}" class="flex items-center gap-2">
                        <input type="date" name="date" value="{{ request('date') }}"
                            class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <select name="status"
                            class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">All Status</option>
                            <option value="success"   {{ request('status') == 'success'     ? 'selected' : '' }}>Success</option>
                            <option value="interrupted" {{ request('status') == 'interrupted' ? 'selected' : '' }}>Interrupted</option>
                            <option value="running"   {{ request('status') == 'running'     ? 'selected' : '' }}>Running</option>
                        </select>
                        <button type="submit"
                            class="bg-green-700 hover:bg-green-800 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                            Filter
                        </button>
                        @if(request('date') || request('status'))
                        <a href="{{ route('history.index') }}"
                            class="text-sm text-gray-500 hover:text-gray-700 px-3 py-2 border border-gray-200 rounded-lg">
                            Reset
                        </a>
                        @endif
                    </form>
                    {{-- Export --}}
                    <a href="{{ route('history.export') }}"
                        class="flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export CSV
                    </a>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-4 gap-4 mb-6">

                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalSuccess }}</p>
                            <p class="text-xs text-gray-400">Total Sukses</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalToday }}</p>
                            <p class="text-xs text-gray-400">Hari Ini</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3c0 0-6 6.5-6 10.5a6 6 0 0012 0C18 9.5 12 3 12 3z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalVolume }}L</p>
                            <p class="text-xs text-gray-400">Total Volume</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalInterrupted }}</p>
                            <p class="text-xs text-gray-400">Interrupted</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Table --}}
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-sm font-bold text-gray-800">Log Penyiraman</h2>
                    <span class="text-xs text-gray-400">{{ $logs->total() }} total records</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-xs text-gray-400 uppercase tracking-wider bg-gray-50">
                                <th class="px-5 py-3 text-left font-semibold">Tanggal & Waktu</th>
                                <th class="px-5 py-3 text-left font-semibold">Selesai</th>
                                <th class="px-5 py-3 text-left font-semibold">Durasi</th>
                                <th class="px-5 py-3 text-left font-semibold">Volume (Est)</th>
                                <th class="px-5 py-3 text-left font-semibold">Trigger</th>
                                <th class="px-5 py-3 text-left font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($logs as $log)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-4">
                                    <p class="font-medium text-gray-800">
                                        {{ $log->started_at->format('M d, Y') }}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        {{ $log->started_at->format('H:i:s') }}
                                    </p>
                                </td>
                                <td class="px-5 py-4 text-gray-600">
                                    {{ $log->ended_at ? $log->ended_at->format('H:i:s') : '—' }}
                                </td>
                                <td class="px-5 py-4">
                                    @if($log->duration_minutes !== null)
                                        <span class="font-bold text-gray-800">{{ $log->duration_minutes }}m</span>
                                        <span class="font-bold text-gray-800"> {{ $log->duration_seconds }}s</span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <span class="font-medium {{ ($log->volume_liters ?? 0) > 50 ? 'text-orange-500' : 'text-gray-800' }}">
                                        {{ $log->volume_liters ?? '—' }}
                                        {{ $log->volume_liters ? 'Liters' : '' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="text-xs font-medium px-2.5 py-1 rounded-full
                                        {{ $log->trigger === 'auto' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                        {{ strtoupper($log->trigger) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="text-xs font-bold px-2.5 py-1 rounded-md border {{ $log->status_color }}">
                                        {{ $log->status_badge }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 font-medium">Belum ada riwayat penyiraman</p>
                                        <p class="text-gray-400 text-xs">Data akan muncul setelah pompa pertama kali diaktifkan</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($logs->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $logs->links() }}
                </div>
                @endif
            </div>

        </main>
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
                    <p class="text-xs font-semibold text-gray-800">Riwayat Penyiraman</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $logs->total() }} total record tersimpan</p>
                    <p class="text-xs text-gray-400 mt-1">Diperbarui otomatis</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('modal-notif').addEventListener('click', function(e) {
        if (e.target === this) this.classList.add('hidden');
    });
</script>
</body>
</html>