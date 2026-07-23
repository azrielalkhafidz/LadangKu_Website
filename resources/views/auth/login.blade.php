@extends('layouts.auth')
@section('title', 'Login — LadangKu')

@section('content')
<div class="min-h-screen flex">

    {{-- ===== KIRI: FORM LOGIN ===== --}}
    <div class="w-full lg:w-[42%] flex flex-col justify-between px-10 py-10 bg-white">

        {{-- Logo --}}
        <div>
            <div class="flex items-center gap-2 mb-8">
                <svg class="w-7 h-7 text-green-700" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17 8C8 10 5.9 16.17 3.82 19.53L5.71 21l1-1.5A4.49 4.49 0 008 21a4.5 4.5 0 004.5-4.5c0-1.93-1.54-3.58-3-4.5C11 14 13 14.5 15 13c3-2 4-5 4-5s-1 1-2 0z"/>
                </svg>
                <div>
                    <p class="font-bold text-gray-900 text-base leading-tight">LadangKu</p>
                    <p class="text-xs text-gray-400 leading-tight">
                        Smart <span class="text-green-600 font-medium">Farming</span>,
                        Better <span class="text-green-600 font-medium">Future</span>
                    </p>
                </div>
            </div>

            {{-- Judul --}}
            <h1 class="text-3xl font-bold text-gray-900 mb-1">Selamat Datang</h1>
            <p class="text-sm text-gray-500 mb-8">
                Masuk ke akun Anda untuk mengelola pertanian pintar Anda secara real-time.
            </p>

            {{-- Error --}}
            @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-600">
                {{ $errors->first() }}
            </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login.post') }}" x-data="{ showPass: false }">
                @csrf

                {{-- Email --}}
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm
                                   focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
                                   @error('email') border-red-400 @enderror"
                            required autofocus
                        >
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <input
                            :type="showPass ? 'text' : 'password'"
                            name="password"
                            placeholder="Masukkan kata sandi"
                            class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm
                                   focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
                                   @error('password') border-red-400 @enderror"
                            required
                        >
                        <button type="button"
                            @click="showPass = !showPass"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember + Lupa Password --}}
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                        <span class="text-sm text-gray-600">Ingat Saya</span>
                    </label>
                    <a href="#" class="text-sm text-green-600 hover:text-green-700 font-medium">Lupa Kata Sandi?</a>
                </div>

                {{-- Tombol Login --}}
                <button type="submit"
                    class="w-full bg-green-700 hover:bg-green-800 text-white font-semibold py-3 px-4 rounded-lg
                           transition-colors duration-200 flex items-center justify-center gap-2 text-sm">
                    Masuk Ke Dashboard
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>

            </form>
        </div>

        {{-- Bottom --}}
        <div class="text-center space-y-4 mt-8">
            <p class="text-sm text-gray-500">
                Belum memiliki akses?
                <a href="#" class="text-green-600 hover:text-green-700 font-medium">Hubungi Admin Sistem</a>
            </p>
            <div class="flex items-center justify-center gap-2 text-xs text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                SECURED BY LADANGKU CLOUD
            </div>
        </div>

    </div>

    {{-- ===== KANAN: FOTO + OVERLAY ===== --}}
    <div class="hidden lg:block lg:w-[58%] relative overflow-hidden">

        {{-- Background image greenhouse --}}
        <div class="absolute inset-0 bg-gradient-to-br from-green-900 via-green-800 to-green-950">
            {{-- Overlay gradient --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-black/10"></div>
            {{-- Pattern dots dekoratif --}}
            <div class="absolute inset-0 opacity-10"
                style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 30px 30px;">
            </div>
        </div>

        {{-- Badge Suhu Udara (kanan atas) --}}
        <div class="absolute top-6 right-6 bg-white/90 backdrop-blur-sm rounded-xl px-4 py-2.5 shadow-lg">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Suhu Udara</p>
                    <p class="text-sm font-bold text-gray-800">24.5°C</p>
                </div>
            </div>
        </div>

        {{-- Badge Kelembaban (kanan atas, kedua) --}}
        <div class="absolute top-24 right-6 bg-white/90 backdrop-blur-sm rounded-xl px-4 py-2.5 shadow-lg">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3c0 0-6 6.5-6 10.5a6 6 0 0012 0C18 9.5 12 3 12 3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Kelembaban</p>
                    <p class="text-sm font-bold text-gray-800">64%</p>
                </div>
            </div>
        </div>

        {{-- Konten bawah --}}
        <div class="absolute bottom-0 left-0 right-0 p-10">

            {{-- Badge pills --}}
            <div class="flex gap-2 mb-4">
                <span class="flex items-center gap-1.5 bg-white/20 backdrop-blur-sm text-white text-xs font-medium px-3 py-1.5 rounded-full border border-white/30">
                    <span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span>
                    Real-time Monitoring
                </span>
                <span class="flex items-center gap-1.5 bg-white/20 backdrop-blur-sm text-white text-xs font-medium px-3 py-1.5 rounded-full border border-white/30">
                    <span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span>
                    Predictive AI
                </span>
            </div>

            <h2 class="text-4xl font-bold text-white leading-tight mb-3">
                Solusi Pertanian Presisi<br>Masa Depan
            </h2>
            <p class="text-white/80 text-sm leading-relaxed max-w-md">
                LadangKu mengintegrasikan sensor tanah, kelembaban, dan data cuaca
                untuk memberikan wawasan mendalam bagi produktivitas panen Anda.
            </p>
        </div>

    </div>

</div>
@endsection