<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-base text-campus-blue">Koleksi Seminar Saya</h2>
    </x-slot>

    @if($seminars->isEmpty())
        <div class="bg-white border border-campus-gray/40 rounded-xl shadow-sm p-12 text-center max-w-md mx-auto mt-8">
            <div class="w-14 h-14 rounded-xl mx-auto mb-4 flex items-center justify-center bg-campus-orange/10">
                <svg class="w-8 h-8 text-campus-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                </svg>
            </div>
            <p class="font-bold text-campus-blue">Koleksi Masih Kosong</p>
            <p class="text-sm text-gray-400 mt-1 mb-5">Anda belum menyimpan materi seminar apa pun.</p>
            <a href="{{ route('seminar.index') }}"
               class="inline-flex items-center gap-1.5 bg-campus-blue hover:bg-campus-blue-d text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Jelajahi Seminar
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($seminars as $item)
                <div class="bg-white border border-campus-gray/40 border-t-[3px] border-t-campus-orange rounded-xl shadow-sm p-5 flex flex-col transition hover:shadow-md hover:-translate-y-0.5">
                    <div class="flex items-start justify-between gap-2 mb-3">
                        <span class="inline-block bg-campus-blue/10 text-campus-blue text-[0.7rem] font-bold px-2.5 py-1 rounded-full tracking-wide uppercase">
                            {{ $item->kategori_prodi }}
                        </span>
                        <svg class="w-4 h-4 flex-shrink-0 text-campus-orange fill-current" viewBox="0 0 24 24">
                            <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-sm leading-snug mb-3 text-campus-dark">{{ $item->judul }}</h3>
                    <div class="mt-auto pt-3 border-t border-campus-gray/30">
                        <a href="{{ route('seminar.show', $item->id) }}"
                           class="inline-flex items-center gap-1.5 bg-campus-blue hover:bg-campus-blue-d text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm w-full justify-center">
                            Lihat Detail
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>