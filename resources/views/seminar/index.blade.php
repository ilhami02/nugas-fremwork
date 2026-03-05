<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-base" style="color: #0f2c5e;">Daftar Arsip Seminar</h2>
            @if(auth()->user()->is_admin)
            <a href="{{ route('seminar.create') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Arsip
            </a>
            @endif
        </div>
    </x-slot>

    @if (session('success'))
        <div class="alert-success flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Search & Filter -->
    <div class="campus-card p-4 mb-6">
        <form action="{{ route('seminar.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="flex-grow relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari judul, pembicara, atau topik..."
                       class="campus-input pl-9">
            </div>
            <div class="w-full md:w-1/4">
                <select name="kategori" class="campus-input">
                    <option value="">Semua Program Studi</option>
                    <option value="Teknik Informatika" {{ request('kategori') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                    <option value="Teknik Mesin" {{ request('kategori') == 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                    <option value="Teknik Elektronika" {{ request('kategori') == 'Teknik Elektronika' ? 'selected' : '' }}>Teknik Elektronika</option>
                    <option value="Umum" {{ request('kategori') == 'Umum' ? 'selected' : '' }}>Umum</option>
                </select>
            </div>
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Cari
            </button>
            @if(request('search') || request('kategori'))
                <a href="{{ route('seminar.index') }}" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($seminars as $item)
            <div class="campus-card campus-card-accent p-5 flex flex-col">
                <div class="flex items-start justify-between gap-2 mb-3">
                    <span class="badge-prodi">{{ $item->kategori_prodi }}</span>
                    <span class="text-xs text-gray-400 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal_acara)->format('d M Y') }}</span>
                </div>
                <h3 class="font-bold text-sm leading-snug mb-2" style="color: #1e293b;">{{ $item->judul }}</h3>
                <p class="text-xs text-gray-500 mb-1 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    {{ $item->pembicara }}
                </p>
                <div class="mt-auto pt-4 border-t border-gray-100 flex gap-2 flex-wrap">
                    <a href="{{ route('seminar.show', $item->id) }}" class="btn-primary text-xs px-3 py-1.5">
                        Lihat Detail
                    </a>
                    @if($item->file_modul)
                        <a href="{{ asset('storage/' . $item->file_modul) }}" target="_blank" class="btn-secondary text-xs px-3 py-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Unduh Modul
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-3">
                <div class="campus-card p-12 text-center">
                    <div class="w-14 h-14 rounded-xl mx-auto mb-4 flex items-center justify-center" style="background: #e8eef8;">
                        <svg class="w-8 h-8" style="color: #0f2c5e;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    </div>
                    <p class="font-semibold" style="color: #0f2c5e;">Arsip seminar tidak ditemukan</p>
                    <p class="text-sm text-gray-500 mt-1">Coba ubah kata kunci atau filter pencarian Anda.</p>
                </div>
            </div>
        @endforelse
    </div>
</x-app-layout>