<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-base" style="color: #0f2c5e;">Dashboard</h2>
    </x-slot>

    <!-- Welcome Banner -->
    <div class="rounded-2xl p-8 mb-8 text-white relative overflow-hidden shadow-lg"
         style="background: linear-gradient(135deg, #0f2c5e 0%, #1a4080 70%, #0f2c5e 100%);">
        <div class="absolute right-0 top-0 bottom-0 w-64 opacity-5" style="background: url('{{ asset('logo_pnc.png') }}') no-repeat center/contain;"></div>
        <div class="relative">
            <p class="text-sm font-medium mb-1" style="color: #f5c518;">Selamat datang kembali,</p>
            <h1 class="text-2xl font-bold mb-2">{{ Auth::user()->name }}</h1>
            <p class="text-sm text-white/70">Akses arsip seminar, kelola koleksi, dan manfaatkan fitur AI untuk pembelajaran.</p>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <!-- Arsip Seminar -->
        <a href="{{ route('seminar.index') }}" class="campus-card campus-card-accent p-6 flex items-start gap-4 group" style="text-decoration:none;">
            <div class="p-3 rounded-xl flex-shrink-0" style="background: #e8eef8;">
                <svg class="w-6 h-6" style="color: #0f2c5e;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-sm" style="color: #0f2c5e;">Arsip Seminar</h3>
                <p class="text-xs mt-1" style="color: #64748b;">Jelajahi seluruh koleksi arsip materi seminar dari berbagai program studi.</p>
            </div>
        </a>

        <!-- Koleksi Saya -->
        <a href="{{ route('seminar.bookmarks') }}" class="campus-card campus-card-bookmark p-6 flex items-start gap-4 group" style="text-decoration:none;">
            <div class="p-3 rounded-xl flex-shrink-0" style="background: #fef9e7;">
                <svg class="w-6 h-6" style="color: #c8a000;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-sm" style="color: #c8a000;">Koleksi Saya</h3>
                <p class="text-xs mt-1" style="color: #64748b;">Akses cepat ke seminar yang sudah kamu simpan dan tandai.</p>
            </div>
        </a>

        <!-- Profil -->
        <a href="{{ route('profile.edit') }}" class="campus-card p-6 flex items-start gap-4 group" style="text-decoration:none;">
            <div class="p-3 rounded-xl flex-shrink-0" style="background: #f0fdf4;">
                <svg class="w-6 h-6" style="color: #166534;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-sm" style="color: #166534;">Profil Saya</h3>
                <p class="text-xs mt-1" style="color: #64748b;">Perbarui informasi akun dan kata sandi kamu.</p>
            </div>
        </a>
    </div>

    @if(Auth::user()->is_admin)
    <div class="mt-6">
        <a href="{{ route('admin.dashboard') }}" class="campus-card p-5 flex items-center gap-4 group" style="text-decoration:none; border-left: 4px solid #c8a000;">
            <div class="p-3 rounded-xl flex-shrink-0" style="background: #fef9e7;">
                <svg class="w-6 h-6" style="color: #c8a000;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="font-semibold text-sm" style="color: #c8a000;">Panel Admin</h3>
                <p class="text-xs mt-0.5" style="color: #64748b;">Kelola konten seminar, tambah arsip, dan pantau statistik sistem.</p>
            </div>
            <svg class="w-5 h-5 text-gray-400 group-hover:text-yellow-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
    @endif
</x-app-layout>
