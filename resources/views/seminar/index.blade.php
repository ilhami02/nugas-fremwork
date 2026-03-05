<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Arsip Seminar') }}
            </h2>
            @if(auth()->user()->is_admin)
            <a href="{{ route('seminar.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                + Tambah Arsip
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <form action="{{ route('seminar.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    
                    <div class="flex-grow">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, pembicara, atau topik..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>

                    <div class="w-full md:w-1/4">
                        <select name="kategori" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">Semua Prodi</option>
                            <option value="Teknik Informatika" {{ request('kategori') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                            <option value="Teknik Mesin" {{ request('kategori') == 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                            <option value="Teknik Elektronika" {{ request('kategori') == 'Teknik Elektronika' ? 'selected' : '' }}>Teknik Elektronika</option>
                            <option value="Umum" {{ request('kategori') == 'Umum' ? 'selected' : '' }}>Umum</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-md shadow transition duration-150">
                        Cari
                    </button>
                    
                    @if(request('search') || request('kategori'))
                        <a href="{{ route('seminar.index') }}" class="bg-red-100 hover:bg-red-200 text-red-700 font-bold py-2 px-4 rounded-md shadow transition duration-150 flex items-center justify-center">
                            X Reset
                        </a>
                    @endif

                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @forelse ($seminars as $item)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-blue-500">
                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-1 rounded">{{ $item->kategori_prodi }}</span>
                        
                        <h3 class="text-xl font-bold mt-3 mb-2 text-gray-800">{{ $item->judul }}</h3>
                        <p class="text-sm text-gray-600 mb-1">🗣️ <strong>Pembicara:</strong> {{ $item->pembicara }}</p>
                        <p class="text-sm text-gray-600 mb-4">📅 <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($item->tanggal_acara)->format('d M Y') }}</p>
                        
                        <div class="mt-4 flex space-x-2 border-t pt-4">
                            <a href="{{ route('seminar.show', $item->id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-1.5 px-3 border border-gray-300 rounded shadow-sm text-sm">
                                Lihat Detail
                            </a>
                            
                            @if($item->file_modul)
                                <a href="{{ asset('storage/' . $item->file_modul) }}" target="_blank" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-1.5 px-3 rounded shadow-sm text-sm flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 prefixed 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Modul
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white p-10 text-center text-gray-500 rounded-lg shadow-sm">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <p class="text-lg">Belum ada arsip seminar yang ditambahkan.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>