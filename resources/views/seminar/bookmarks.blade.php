<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-base" style="color: #0f2c5e;">Koleksi Seminar Saya</h2>
    </x-slot>

    @if($seminars->isEmpty())
        <div class="campus-card p-12 text-center max-w-md mx-auto mt-8">
            <div class="w-14 h-14 rounded-xl mx-auto mb-4 flex items-center justify-center" style="background: #fef9e7;">
                <svg class="w-8 h-8" style="color: #c8a000;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                </svg>
            </div>
            <p class="font-bold" style="color: #0f2c5e;">Koleksi Masih Kosong</p>
            <p class="text-sm text-gray-500 mt-1 mb-5">Anda belum menyimpan materi seminar apa pun.</p>
            <a href="{{ route('seminar.index') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Jelajahi Seminar
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($seminars as $item)
                <div class="campus-card campus-card-bookmark p-5 flex flex-col">
                    <div class="flex items-start justify-between gap-2 mb-3">
                        <span class="badge-prodi">{{ $item->kategori_prodi }}</span>
                        <svg class="w-4 h-4 flex-shrink-0" style="color: #c8a000;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-sm leading-snug mb-3" style="color: #1e293b;">{{ $item->judul }}</h3>
                    <div class="mt-auto pt-3 border-t border-gray-100">
                        <a href="{{ route('seminar.show', $item->id) }}" class="btn-primary text-xs w-full justify-center">
                            Lihat Detail
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>