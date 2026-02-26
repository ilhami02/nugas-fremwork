<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Koleksi Seminar Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @forelse ($seminars as $item)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-yellow-400">
                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-1 rounded">{{ $item->kategori_prodi }}</span>
                        <h3 class="text-xl font-bold mt-3 mb-2 text-gray-800">{{ $item->judul }}</h3>
                        
                        <div class="mt-4">
                            <a href="{{ route('seminar.show', $item->id) }}" class="text-blue-600 hover:text-blue-800 font-bold text-sm">
                                Lihat Detail &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-yellow-50 p-10 text-center text-yellow-800 rounded-lg border border-yellow-200">
                        <p class="text-lg font-bold">Koleksi Masih Kosong</p>
                        <p>Anda belum menyimpan materi seminar apa pun.</p>
                        <a href="{{ route('seminar.index') }}" class="text-blue-600 underline mt-2 inline-block">Cari Seminar</a>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>