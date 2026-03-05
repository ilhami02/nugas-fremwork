{{-- Loading bar --}}
<div id="page-loader" style="position:fixed;top:0;left:0;width:0;height:3px;background:#ee9b11;z-index:9999;transition:none;"></div>

<script>
(function () {
    var bar = document.getElementById('page-loader');
    var timer, done = false;

    function start() {
        done = false;
        bar.style.transition = 'none';
        bar.style.width = '0';
        bar.style.opacity = '1';
        setTimeout(function () {
            bar.style.transition = 'width 10s cubic-bezier(0.1, 0.05, 0, 1)';
            bar.style.width = '85%';
        }, 10);
    }

    function finish() {
        if (done) return;
        done = true;
        bar.style.transition = 'width 0.2s ease';
        bar.style.width = '100%';
        setTimeout(function () {
            bar.style.transition = 'opacity 0.4s ease';
            bar.style.opacity = '0';
            setTimeout(function () { bar.style.width = '0'; }, 400);
        }, 200);
    }

    // Start on link/form navigation
    document.addEventListener('click', function (e) {
        var a = e.target.closest('a[href]');
        if (a && !a.target && !a.href.startsWith('#') && !a.href.startsWith('javascript') && a.href !== window.location.href) {
            start();
        }
    });
    document.addEventListener('submit', function (e) {
        // Only fire for non-AJAX forms (data-diskusi, rating, bookmark are AJAX)
        var f = e.target;
        if (!f.dataset.diskusi && f.id !== 'rating-form' && f.id !== 'bookmark-form') {
            start();
        }
    });

    window.addEventListener('pageshow', finish);
    window.addEventListener('load', finish);
})();
</script>

<nav x-data="{ open: false }" class="bg-campus-blue border-b-[3px] border-campus-orange shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo & Brand -->
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group no-underline">
                    <img src="{{ asset('https://pnc.ac.id/wp-content/uploads/2020/03/Logo-PNC.png') }}"
                         alt="Logo PNC"
                         class="h-10 w-10 rounded-lg object-contain bg-white p-0.5 shadow-sm">
                    <div class="hidden sm:block">
                        <div class="text-white font-bold text-base leading-tight tracking-wide">KMS Politeknik Negeri Cilacap</div>
                        <div class="text-xs font-medium text-campus-orange tracking-wider">Knowledge Management System</div>
                    </div>
                </a>
            </div>

            <!-- Desktop Nav Links -->
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
                   class="px-4 py-2 rounded-md text-sm font-semibold transition-all flex items-center gap-1.5 border border-campus-orange/50
                   {{ request()->routeIs('admin.dashboard') ? 'bg-campus-orange text-white' : 'bg-campus-orange/20 text-campus-orange hover:bg-campus-orange/30' }}">
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
                            <div class="h-8 w-8 rounded-full flex items-center justify-center text-white font-bold text-sm shadow bg-campus-orange">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Masuk sebagai</p>
                            <p class="text-sm font-semibold text-campus-dark truncate mt-0.5">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            <svg class="w-4 h-4 mr-2 text-campus-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profil Saya
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                <svg class="w-4 h-4 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Keluar
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white/70 hover:text-white hover:bg-white/10 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-campus-blue/95 border-t border-white/10">
        <div class="pt-2 pb-3 space-y-1 px-3">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2.5 rounded-md text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">Dashboard</a>
            <a href="{{ route('seminar.index') }}" class="block px-3 py-2.5 rounded-md text-sm font-medium {{ request()->routeIs('seminar.index') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">Arsip Seminar</a>
            <a href="{{ route('seminar.bookmarks') }}" class="block px-3 py-2.5 rounded-md text-sm font-medium {{ request()->routeIs('seminar.bookmarks') ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">Koleksi Saya</a>
            @if(Auth::check() && Auth::user()->is_admin)
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2.5 rounded-md text-sm font-medium text-campus-orange hover:bg-white/10">Panel Admin</a>
            @endif
        </div>
        <div class="pt-3 pb-3 border-t border-white/10 px-3">
            <div class="flex items-center gap-3 px-3 mb-3">
                <div class="h-9 w-9 rounded-full flex items-center justify-center text-white font-bold text-sm bg-campus-orange">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="text-sm font-semibold text-white">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-white/60">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white/80 hover:bg-white/10">Profil Saya</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-sm font-medium text-red-300 hover:bg-white/10">Keluar</button>
            </form>
        </div>
    </div>
</nav>
