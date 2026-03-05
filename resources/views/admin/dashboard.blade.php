<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-base flex items-center gap-2 text-campus-blue">
            <svg class="w-5 h-5 text-campus-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Panel Admin — KMS PNC
        </h2>
    </x-slot>

    @if (session('success'))
        <div data-alert class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm flex items-center gap-2 mb-4">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
    @endif

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
        <div class="bg-white border border-campus-gray/40 border-l-4 border-l-campus-blue rounded-xl shadow-sm p-5 flex items-center gap-4">
            <div class="p-3 rounded-xl bg-campus-blue/10">
                <svg class="w-6 h-6 text-campus-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Total Seminar</p>
                <p class="text-3xl font-bold text-campus-blue">{{ $totalSeminar }}</p>
            </div>
        </div>
        <div class="bg-white border border-campus-gray/40 border-l-4 border-l-campus-orange rounded-xl shadow-sm p-5 flex items-center gap-4">
            <div class="p-3 rounded-xl bg-campus-orange/10">
                <svg class="w-6 h-6 text-campus-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Total Tayangan</p>
                <p class="text-3xl font-bold text-campus-orange">{{ $totalViews }}</p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white border border-campus-gray/40 rounded-xl shadow-sm overflow-hidden">
        <div class="p-5 border-b border-campus-gray/30 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h3 class="flex items-center gap-2 text-lg font-bold text-campus-blue">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                Manajemen Konten Seminar
            </h3>
            <a href="{{ route('seminar.create') }}"
               class="inline-flex items-center gap-1.5 bg-campus-blue hover:bg-campus-blue-d text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Seminar Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-campus-gray/30">
                        <th class="py-3 px-5 text-xs font-semibold uppercase tracking-wider text-gray-400">Judul Seminar</th>
                        <th class="py-3 px-5 text-xs font-semibold uppercase tracking-wider text-gray-400">Kategori</th>
                        <th class="py-3 px-5 text-xs font-semibold uppercase tracking-wider text-gray-400 text-center">Notulen AI</th>
                        <th class="py-3 px-5 text-xs font-semibold uppercase tracking-wider text-gray-400 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($seminars as $item)
                        <tr class="border-b border-campus-gray/20 hover:bg-campus-blue/5 transition">
                            <td class="py-4 px-5">
                                <div class="font-semibold text-sm text-campus-dark">{{ $item->judul }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">
                                    {{ \Carbon\Carbon::parse($item->tanggal_acara)->format('d M Y') }} &middot; {{ $item->pembicara }}
                                </div>
                            </td>
                            <td class="py-4 px-5">
                                <span class="inline-block bg-campus-blue/10 text-campus-blue text-[0.7rem] font-bold px-2.5 py-1 rounded-full tracking-wide uppercase">
                                    {{ $item->kategori_prodi }}
                                </span>
                            </td>
                            <td class="py-4 px-5 text-center">
                                @if($item->rangkuman_ai)
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-green-50 text-green-700">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Selesai
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-campus-orange/10 text-campus-orange">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Kosong
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('seminar.show', $item->id) }}" title="Lihat Detail" class="p-1.5 rounded-lg hover:bg-campus-blue/10 transition text-campus-blue">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('seminar.live', $item->id) }}" title="Live AI" class="p-1.5 rounded-lg hover:bg-purple-50 transition text-purple-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
                                    </a>
                                    <a href="{{ route('seminar.edit', $item->id) }}" title="Edit" class="p-1.5 rounded-lg hover:bg-campus-orange/10 transition text-campus-orange">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('seminar.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus" class="p-1.5 rounded-lg hover:bg-red-50 transition text-red-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-sm text-gray-400">Belum ada data seminar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>