<nav x-data="{ open: false }" class="campus-navbar">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo & Brand -->
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group" style="text-decoration:none;">
                    <img src="{{ asset('logo_pnc.png') }}" alt="Logo PNC" class="h-10 w-10 rounded-lg object-contain bg-white p-0.5 shadow-sm">
                    <div class="hidden sm:block">
                        <div class="text-white font-bold text-base leading-tight tracking-wide">KMS Politeknik Negeri Cilacap</div>
                        <div class="text-xs font-medium" style="color: #c8a000; letter-spacing:0.04em;">Knowledge Management System</div>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation Links -->
            <div class="hidden sm:flex items-center gap-1">
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 rounded-md text-sm font-medium transition-all
                   {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white font-semibold' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    Dashboard
                </a>
                <a href="{{ route('seminar.index') }}"
                   class="px-4 py-2 rounded-md text-sm font-medium transition-all
                   {{ request()->routeIs('seminar.index') ? 'bg-white/20 text-white font-semibold' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    Arsip Seminar
                </a>
                <a href="{{ route('seminar.bookmarks') }}"
                   class="px-4 py-2 rounded-md text-sm font-medium transition-all
                   {{ request()->routeIs('seminar.bookmarks') ? 'bg-white/20 text-white font-semibold' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    Koleksi Saya
                </a>
                @if(Auth::check() && Auth::user()->is_admin)
                <a href="{{ route('admin.dashboard') }}"
                   class="px-4 py-2 rounded-md text-sm font-semibold transition-all flex items-center gap-1.5
                   {{ request()->routeIs('admin.dashboard') ? 'bg-yellow-500/90 text-white' : 'bg-yellow-500/20 text-yellow-300 hover:bg-yellow-500/30 hover:text-yellow-200' }}"
                   style="border: 1px solid rgba(200,160,0,0.4)">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Panel Admin
                </a>
                @endif
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-white/90 hover:text-white hover:bg-white/10 transition-all focus:outline-none">
                            <div class="h-8 w-8 rounded-full flex items-center justify-center text-white font-bold text-sm shadow" style="background: linear-gradient(135deg, #c8a000, #f5c518);">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Masuk sebagai</p>
                            <p class="text-sm font-semibold text-gray-800 truncate mt-0.5">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ __('Profil Saya') }}
                        </x-dropdown-link>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                <svg class="w-4 h-4 mr-2 inline text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                {{ __('Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white/70 hover:text-white hover:bg-white/10 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" style="background: rgba(15,44,94,0.97); border-top: 1px solid rgba(255,255,255,0.1);">
        <div class="pt-2 pb-3 space-y-1 px-3">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2.5 rounded-md text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">Dashboard</a>
            <a href="{{ route('seminar.index') }}" class="block px-3 py-2.5 rounded-md text-sm font-medium {{ request()->routeIs('seminar.index') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">Arsip Seminar</a>
            <a href="{{ route('seminar.bookmarks') }}" class="block px-3 py-2.5 rounded-md text-sm font-medium {{ request()->routeIs('seminar.bookmarks') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">Koleksi Saya</a>
            @if(Auth::check() && Auth::user()->is_admin)
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2.5 rounded-md text-sm font-medium text-yellow-300 hover:bg-white/10">Panel Admin</a>
            @endif
        </div>

        <!-- Mobile Settings -->
        <div class="pt-3 pb-3 border-t border-white/10 px-3">
            <div class="flex items-center gap-3 px-3 mb-3">
                <div class="h-9 w-9 rounded-full flex items-center justify-center text-white font-bold text-sm" style="background: linear-gradient(135deg, #c8a000, #f5c518);">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="text-sm font-semibold text-white">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-white/60">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white/80 hover:bg-white/10 hover:text-white">Profil Saya</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();" class="w-full text-left px-3 py-2 rounded-md text-sm font-medium text-red-300 hover:bg-white/10">Keluar</button>
            </form>
        </div>
    </div>
</nav>
