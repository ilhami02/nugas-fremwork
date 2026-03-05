<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            {{ __('Admin Panel - Knowledge Management System') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 shadow-sm">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center">
                    <div class="p-4 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Seminar</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalSeminar }}</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center">
                    <div class="p-4 rounded-full bg-green-100 text-green-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Tayangan View</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalViews }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6 bg-white border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Manajemen Konten Seminar</h3>
                    <a href="{{ route('seminar.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow text-sm flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Seminar Baru
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider">
                                <th class="py-4 px-6 border-b border-gray-200">Judul Seminar</th>
                                <th class="py-4 px-6 border-b border-gray-200">Kategori</th>
                                <th class="py-4 px-6 border-b border-gray-200 text-center">Notulen AI</th>
                                <th class="py-4 px-6 border-b border-gray-200 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($seminars as $item)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-gray-800">{{ $item->judul }}</div>
                                        <div class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($item->tanggal_acara)->format('d M Y') }} | Oleh: {{ $item->pembicara }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ $item->kategori_prodi }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if($item->rangkuman_ai)
                                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Selesai</span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Kosong</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center whitespace-nowrap">
                                        <a href="{{ route('seminar.show', $item->id) }}" class="text-blue-500 hover:text-blue-700 mr-3" title="Lihat Publik">👁️</a>
                                        <a href="{{ route('seminar.live', $item->id) }}" class="text-purple-500 hover:text-purple-700 mr-3" title="Mulai Rekam AI">🎙️</a>
                                        <a href="{{ route('seminar.edit', $item->id) }}" class="text-yellow-500 hover:text-yellow-700 mr-3" title="Edit Konten">✏️</a>
                                        
                                        <form action="{{ route('seminar.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus seminar ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus">🗑️</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 px-6 text-center text-gray-500">Belum ada data seminar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>