<aside class="w-56 bg-white border-r border-gray-200 flex flex-col fixed h-full z-30">

    {{-- Logo --}}
    <div class="px-5 py-5 border-b border-gray-100">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-green-700" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17 8C8 10 5.9 16.17 3.82 19.53L5.71 21l1-1.5A4.49 4.49 0 008 21a4.5 4.5 0 004.5-4.5c0-1.93-1.54-3.58-3-4.5C11 14 13 14.5 15 13c3-2 4-5 4-5s-1 1-2 0z"/>
            </svg>
            <div>
                <p class="font-bold text-gray-900 text-sm">LadangKu</p>
                <p class="text-xs text-gray-400">Smart Farming IoT</p>
            </div>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 px-3 py-4 space-y-1">

        <a href="{{ url('/dashboard') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                  {{ request()->is('dashboard') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        <a href="{{ url('/monitoring') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                  {{ request()->is('monitoring*') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Monitoring
        </a>

        <a href="{{ url('/history') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                  {{ request()->is('history*') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            History
        </a>

        <a href="{{ url('/settings') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                  {{ request()->is('settings*') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Settings
        </a>

        <a href="{{ url('/profile') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                  {{ request()->is('profile*') ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Startup Profile
        </a>

    </nav>

    {{-- Bottom --}}
    <div class="px-4 py-4 border-t border-gray-100">
        <div class="flex items-center gap-2 p-2 rounded-lg bg-gray-50">
            <div class="w-7 h-7 rounded-full bg-green-700 flex items-center justify-center flex-shrink-0">
                <span class="text-xs font-bold text-white">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-gray-700 truncate">Admin Panel</p>
                <p class="text-xs text-gray-400">Premium Plan</p>
            </div>
            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors" title="Logout">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>

</aside>