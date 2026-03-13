<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-base text-campus-blue">Daftar Arsip Seminar</h2>
            @if(auth()->user()->is_admin)
            <a href="{{ route('seminar.create') }}"
               class="inline-flex items-center gap-1.5 bg-campus-blue hover:bg-campus-blue-d text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Arsip
            </a>
            @endif
        </div>
    </x-slot>

    @if (session('success'))
        <div data-alert class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm flex items-center gap-2 mb-4">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Search & Filter -->
    <div class="bg-white border border-campus-gray/40 rounded-xl shadow-sm p-4 mb-6">
        <form action="{{ route('seminar.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="flex-grow relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-campus-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari judul, pembicara, atau topik..."
                       class="w-full border border-campus-gray/60 rounded-lg pl-9 pr-3.5 py-2 text-sm text-campus-dark bg-white outline-none transition focus:border-campus-blue focus:ring-2 focus:ring-campus-blue/15">
            </div>
            <div class="w-full md:w-1/4">
                <select name="kategori" class="w-full border border-campus-gray/60 rounded-lg px-3.5 py-2 text-sm text-campus-dark bg-white outline-none transition focus:border-campus-blue focus:ring-2 focus:ring-campus-blue/15">
                    <option value="">Semua Program Studi</option>
                    <option value="Teknik Informatika" {{ request('kategori') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                    <option value="Teknik Mesin" {{ request('kategori') == 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                    <option value="Teknik Elektronika" {{ request('kategori') == 'Teknik Elektronika' ? 'selected' : '' }}>Teknik Elektronika</option>
                    <option value="Umum" {{ request('kategori') == 'Umum' ? 'selected' : '' }}>Umum</option>
                </select>
            </div>
            <button type="submit"
                    class="inline-flex items-center gap-1.5 bg-campus-blue hover:bg-campus-blue-d text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Cari
            </button>
            @if(request('search') || request('kategori'))
                <a href="{{ route('seminar.index') }}"
                   class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-campus-dark border border-campus-gray/50 px-4 py-2 rounded-lg text-sm font-semibold transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($seminars as $item)
            <div class="bg-white border border-campus-gray/40 border-t-[3px] border-t-campus-blue rounded-xl shadow-sm flex flex-col transition hover:shadow-md hover:-translate-y-0.5 overflow-hidden">
                {{-- Area konten (klik → detail) --}}
                <a href="{{ route('seminar.show', $item->id) }}" class="block p-5 flex-1">
                    <div class="flex items-start justify-between gap-2 mb-3">
                        <span class="inline-block bg-campus-blue/10 text-campus-blue text-[0.7rem] font-bold px-2.5 py-1 rounded-full tracking-wide uppercase">
                            {{ $item->kategori_prodi }}
                        </span>
                        <span class="text-xs text-gray-400 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal_acara)->format('d M Y') }}</span>
                    </div>
                    <h3 class="font-bold text-sm leading-snug mb-2 text-campus-dark">{{ $item->judul }}</h3>
                    <p class="text-xs text-gray-400 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        {{ $item->pembicara }}
                    </p>
                </a>

                {{-- Area bawah: tombol aksi --}}
                @php $isBookmarked = auth()->user()->bookmarks->contains($item->id); @endphp
                <div class="px-5 py-3 border-t border-campus-gray/30 flex items-center justify-between gap-2">
                    <div class="flex gap-2 flex-wrap">
                        <a href="{{ route('seminar.show', $item->id) }}"
                           class="inline-flex items-center gap-1.5 bg-campus-blue hover:bg-campus-blue-d text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">
                            Lihat Detail
                        </a>
                        @if($item->file_modul)
                            <a href="{{ asset('storage/' . $item->file_modul) }}" target="_blank"
                               class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-campus-dark border border-campus-gray/50 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Unduh
                            </a>
                        @endif
                    </div>

                    {{-- Tombol Bookmark --}}
                    <form class="bookmark-form" action="{{ route('seminar.bookmark', $item->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                                data-bookmarked="{{ $isBookmarked ? 'true' : 'false' }}"
                                title="{{ $isBookmarked ? 'Hapus dari Koleksi' : 'Simpan ke Koleksi' }}"
                                class="bookmark-btn p-1.5 rounded-lg transition {{ $isBookmarked ? 'text-campus-orange' : 'text-campus-gray hover:text-campus-orange' }}">
                            <svg class="w-5 h-5" stroke="currentColor" viewBox="0 0 24 24"
                                 fill="{{ $isBookmarked ? 'currentColor' : 'none' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-3">
                <div class="bg-white border border-campus-gray/40 rounded-xl shadow-sm p-12 text-center">
                    <div class="w-14 h-14 rounded-xl mx-auto mb-4 flex items-center justify-center bg-campus-blue/10">
                        <svg class="w-8 h-8 text-campus-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    </div>
                    <p class="font-semibold text-campus-blue">Arsip seminar tidak ditemukan</p>
                    <p class="text-sm text-gray-400 mt-1">Coba ubah kata kunci atau filter pencarian Anda.</p>
                </div>
            </div>
        @endforelse
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.bookmark-form').forEach(function (form) {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            const btn  = form.querySelector('.bookmark-btn');
            const svg  = btn.querySelector('svg');
            const csrf = form.querySelector('[name=_token]').value;
            const wasBookmarked = btn.dataset.bookmarked === 'true';

            try {
                await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: `_token=${encodeURIComponent(csrf)}`
                });

                const nowBookmarked = !wasBookmarked;
                btn.dataset.bookmarked = nowBookmarked.toString();
                btn.title = nowBookmarked ? 'Hapus dari Koleksi' : 'Simpan ke Koleksi';

                if (nowBookmarked) {
                    btn.classList.remove('text-campus-gray', 'hover:text-campus-orange');
                    btn.classList.add('text-campus-orange');
                    svg.setAttribute('fill', 'currentColor');
                } else {
                    btn.classList.remove('text-campus-orange');
                    btn.classList.add('text-campus-gray', 'hover:text-campus-orange');
                    svg.setAttribute('fill', 'none');
                }
            } catch (err) { console.error('Bookmark error:', err); }
        });
    });
});
</script>