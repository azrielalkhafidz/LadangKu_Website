<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Startup Profile — LadangKu</title>
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
                <input type="text" placeholder="Search..."
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

            {{-- Hero Banner --}}
            <div class="bg-gradient-to-br from-green-700 to-green-900 rounded-2xl p-8 mb-6 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10"
                    style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 24px 24px;">
                </div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17 8C8 10 5.9 16.17 3.82 19.53L5.71 21l1-1.5A4.49 4.49 0 008 21a4.5 4.5 0 004.5-4.5c0-1.93-1.54-3.58-3-4.5C11 14 13 14.5 15 13c3-2 4-5 4-5s-1 1-2 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-white">LadangKu Smart Farming</h1>
                                <p class="text-green-200 text-sm">Startup Agritech — D3 Teknik Komputer, UNIKOM</p>
                            </div>
                        </div>
                        <p class="text-white/80 text-sm max-w-lg leading-relaxed">
                            Sistem monitoring dan penyiraman otomatis tanaman cabai berbasis IoT yang mengintegrasikan
                            sensor tanah, kelembaban udara, dan kontrol jarak jauh untuk meningkatkan produktivitas petani.
                        </p>
                        <div class="flex gap-2 mt-4">
                            <span class="bg-white/20 text-white text-xs font-medium px-3 py-1.5 rounded-full border border-white/30">
                                🌱 Smart Farming
                            </span>
                            <span class="bg-white/20 text-white text-xs font-medium px-3 py-1.5 rounded-full border border-white/30">
                                📡 IoT Based
                            </span>
                            <span class="bg-white/20 text-white text-xs font-medium px-3 py-1.5 rounded-full border border-white/30">
                                🚀 Prototype Stage
                            </span>
                        </div>
                    </div>
                    <div class="hidden lg:flex flex-col items-end gap-3">
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl px-5 py-3 text-center">
                            <p class="text-2xl font-bold text-white">2026</p>
                            <p class="text-green-200 text-xs">Tahun Berdiri</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl px-5 py-3 text-center">
                            <p class="text-2xl font-bold text-white">2</p>
                            <p class="text-green-200 text-xs">Anggota Tim</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
                    <p class="text-2xl font-bold text-green-700">ESP32</p>
                    <p class="text-xs text-gray-400 mt-1">Mikrokontroler</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
                    <p class="text-2xl font-bold text-blue-600">DHT22</p>
                    <p class="text-xs text-gray-400 mt-1">Sensor Utama</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
                    <p class="text-2xl font-bold text-orange-500">Laravel</p>
                    <p class="text-xs text-gray-400 mt-1">Backend Framework</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
                    <p class="text-2xl font-bold text-purple-600">Flutter</p>
                    <p class="text-xs text-gray-400 mt-1">Mobile App</p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6">

                {{-- Tim --}}
                <div class="col-span-2 space-y-4">

                    <h2 class="text-base font-bold text-gray-800">👥 Tim Pengembang</h2>

                    {{-- CEO --}}
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-xl bg-green-700 flex items-center justify-center flex-shrink-0">
                                <span class="text-xl font-bold text-white">A</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-bold text-gray-900">Azriel Al Khafidz</h3>
                                        <p class="text-sm text-gray-500">NIM: 10824007</p>
                                    </div>
                                    <span class="text-xs font-bold bg-green-100 text-green-700 px-3 py-1 rounded-full">CEO</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-2 leading-relaxed">
                                    Chief Executive Officer — Bertanggung jawab memimpin jalannya proyek,
                                    mengoordinasikan anggota tim, mengelola perencanaan dan timeline proyek,
                                    serta melakukan pelaporan kepada dosen pembimbing.
                                </p>
                                <div class="flex gap-2 mt-3">
                                    <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Project Management</span>
                                    <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Documentation</span>
                                    <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Business</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CTO --}}
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-xl bg-blue-600 flex items-center justify-center flex-shrink-0">
                                <span class="text-xl font-bold text-white">K</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-bold text-gray-900">Keandra Indraputra</h3>
                                        <p class="text-sm text-gray-500">NIM: 10824011</p>
                                    </div>
                                    <span class="text-xs font-bold bg-blue-100 text-blue-700 px-3 py-1 rounded-full">CTO</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-2 leading-relaxed">
                                    Chief Technology Officer — Bertanggung jawab terhadap pengembangan teknologi sistem,
                                    perancangan arsitektur hardware dan software, integrasi sensor ESP32,
                                    pengembangan backend Laravel, dan aplikasi mobile Flutter.
                                </p>
                                <div class="flex gap-2 mt-3">
                                    <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">IoT Hardware</span>
                                    <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Laravel</span>
                                    <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Flutter</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tech Stack --}}
                    <h2 class="text-base font-bold text-gray-800 pt-2">🛠️ Technology Stack</h2>
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <div class="grid grid-cols-2 gap-3">
                            @foreach([
                                ['ESP32', 'Mikrokontroler utama', 'bg-green-100 text-green-700'],
                                ['Soil Moisture Sensor', 'Sensor kelembaban tanah', 'bg-yellow-100 text-yellow-700'],
                                ['DHT22', 'Sensor suhu & kelembaban udara', 'bg-blue-100 text-blue-700'],
                                ['Relay + Pompa Air', 'Aktuator penyiraman', 'bg-purple-100 text-purple-700'],
                                ['Laravel', 'Backend & REST API', 'bg-red-100 text-red-700'],
                                ['MySQL', 'Database', 'bg-orange-100 text-orange-700'],
                                ['Flutter', 'Aplikasi Mobile', 'bg-cyan-100 text-cyan-700'],
                                ['Tailwind CSS', 'Web Frontend', 'bg-sky-100 text-sky-700'],
                            ] as [$name, $desc, $color])
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-50">
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $color }}">
                                    {{ $name }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $desc }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                {{-- Sidebar Info --}}
                <div class="space-y-4">

                    {{-- Info Startup --}}
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h3 class="text-sm font-bold text-gray-800 mb-4">📋 Info Startup</h3>
                        <div class="space-y-3">
                            @foreach([
                                ['Nama', 'LadangKu Smart Farming'],
                                ['Bidang', 'Agritech / IoT'],
                                ['Stage', 'Prototype'],
                                ['Tahun', '2026'],
                                ['Kampus', 'UNIKOM Bandung'],
                                ['Prodi', 'D3 Teknik Komputer'],
                                ['Dosen', 'Dr. Agus Mulyana, MT'],
                                ['Kelas', 'TK-1 / D3 2024'],
                            ] as [$label, $value])
                            <div class="flex justify-between items-start gap-2">
                                <span class="text-xs text-gray-400 flex-shrink-0">{{ $label }}</span>
                                <span class="text-xs font-medium text-gray-700 text-right">{{ $value }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Visi Misi --}}
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h3 class="text-sm font-bold text-gray-800 mb-3">🎯 Visi</h3>
                        <p class="text-xs text-gray-600 leading-relaxed mb-4">
                            Menjadi platform agritech terpercaya yang membantu petani cabai Indonesia
                            meningkatkan produktivitas melalui teknologi IoT yang terjangkau dan mudah digunakan.
                        </p>
                        <h3 class="text-sm font-bold text-gray-800 mb-3">📌 Misi</h3>
                        <ul class="space-y-1.5">
                            @foreach([
                                'Monitoring lahan real-time berbasis IoT',
                                'Penyiraman otomatis hemat air',
                                'Dashboard mudah diakses petani',
                                'Teknologi terjangkau skala kecil',
                            ] as $misi)
                            <li class="flex items-start gap-2 text-xs text-gray-600">
                                <span class="text-green-600 mt-0.5 flex-shrink-0">✓</span>
                                {{ $misi }}
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Links --}}
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h3 class="text-sm font-bold text-gray-800 mb-3">🔗 Links</h3>
                        <div class="space-y-2">
                            <a href="https://github.com/azrielalkhafidz/LadangKU_OTA"
                               target="_blank"
                               class="flex items-center gap-2 text-sm text-gray-700 hover:text-green-700 transition-colors p-2 rounded-lg hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
                                </svg>
                                GitHub Repository
                            </a>
                            <a href="#"
                               class="flex items-center gap-2 text-sm text-gray-700 hover:text-blue-700 transition-colors p-2 rounded-lg hover:bg-gray-50">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                                LinkedIn Startup
                            </a>
                            <a href="#"
                               class="flex items-center gap-2 text-sm text-gray-700 hover:text-pink-600 transition-colors p-2 rounded-lg hover:bg-gray-50">
                                <svg class="w-4 h-4 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                </svg>
                                Instagram Startup
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </main>
    </div>
</div>

</body>
</html>