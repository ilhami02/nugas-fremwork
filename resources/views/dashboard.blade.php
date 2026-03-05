<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-base text-campus-blue">Dashboard</h2>
    </x-slot>

    <!-- Welcome Banner -->
    <div class="rounded-2xl p-8 mb-8 text-white relative overflow-hidden shadow-lg"
         style="background: linear-gradient(135deg, #0a3a55 0%, #0e4b6d 70%, #0a3a55 100%);">
        <div class="absolute my-2 right-0 top-0 bottom-0 w-64 opacity-60"
             style="background: url('https://pnc.ac.id/wp-content/uploads/2020/03/Logo-PNC.png') no-repeat center/contain;"></div>
        <div class="relative">
            <p class="text-sm font-medium mb-1 text-campus-orange">Selamat datang kembali,</p>
            <h1 class="text-2xl font-bold mb-2">{{ Auth::user()->name }}</h1>
            <p class="text-sm text-white/70">Akses arsip seminar, kelola koleksi, dan fitur pembelajaran.</p>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <a href="{{ route('seminar.index') }}"
           class="bg-white border border-campus-gray/40 border-t-[3px] border-t-campus-blue rounded-xl shadow-sm p-6 flex items-start gap-4 group transition hover:shadow-md hover:-translate-y-0.5 no-underline">
            <div class="p-3 rounded-xl flex-shrink-0 bg-campus-blue/10">
                <svg class="w-6 h-6 text-campus-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-sm text-campus-blue">Arsip Seminar</h3>
                <p class="text-xs mt-1 text-gray-500">Jelajahi seluruh koleksi arsip materi seminar dari berbagai program studi.</p>
            </div>
        </a>

        <a href="{{ route('seminar.bookmarks') }}"
           class="bg-white border border-campus-gray/40 border-t-[3px] border-t-campus-orange rounded-xl shadow-sm p-6 flex items-start gap-4 group transition hover:shadow-md hover:-translate-y-0.5 no-underline">
            <div class="p-3 rounded-xl flex-shrink-0 bg-campus-orange/10">
                <svg class="w-6 h-6 text-campus-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-sm text-campus-orange">Koleksi Saya</h3>
                <p class="text-xs mt-1 text-gray-500">Akses cepat ke seminar yang sudah kamu simpan dan tandai.</p>
            </div>
        </a>

        <a href="{{ route('profile.edit') }}"
           class="bg-white border border-campus-gray/40 border-t-[3px] border-t-green-500 rounded-xl shadow-sm p-6 flex items-start gap-4 group transition hover:shadow-md hover:-translate-y-0.5 no-underline">
            <div class="p-3 rounded-xl flex-shrink-0 bg-green-50">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-sm text-green-700">Profil Saya</h3>
                <p class="text-xs mt-1 text-gray-500">Perbarui informasi akun dan kata sandi kamu.</p>
            </div>
        </a>
    </div>

    @if(Auth::user()->is_admin)
    <div class="mt-6">
        <a href="{{ route('admin.dashboard') }}"
           class="bg-white border border-campus-gray/40 border-l-4 border-l-campus-orange rounded-xl shadow-sm p-5 flex items-center gap-4 group transition hover:shadow-md no-underline">
            <div class="p-3 rounded-xl flex-shrink-0 bg-campus-orange/10">
                <svg class="w-6 h-6 text-campus-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="font-semibold text-sm text-campus-orange">Panel Admin</h3>
                <p class="text-xs mt-0.5 text-gray-500">Kelola konten seminar, tambah arsip, dan pantau statistik sistem.</p>
            </div>
            <svg class="w-5 h-5 text-gray-300 group-hover:text-campus-orange transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
    @endif
</x-app-layout>
