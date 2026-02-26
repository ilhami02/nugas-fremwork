<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Materi Seminar') }}
            </h2>
            <a href="{{ route('seminar.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded shadow text-sm">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                @if($seminar->url_video)
                <div class="aspect-w-16 aspect-h-9 w-full">
                    <iframe class="w-full h-96" src="{{ $seminar->url_video }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500">Video rekaman tidak tersedia untuk seminar ini.</span>
                </div>
                @endif
                <div class="p-6 sm:p-8"> 

                    <div class="mb-4">
                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1.5 rounded-full">
                            {{ $seminar->kategori_prodi }}
                        </span>
                    </div>

                    <h1 class="text-3xl font-bold mb-2 text-gray-900">
                        {{ $seminar->judul }}
                    </h1>

                    <div class="flex items-center text-sm text-gray-600 mb-6 pb-6 border-b border-gray-200 mt-2">
                        <span class="mr-6 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <strong>Oleh:</strong> &nbsp; {{ $seminar->pembicara }}
                        </span>
                        <<span class="flex items-center mr-6">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">...</svg>
                            <strong>Tanggal:</strong> &nbsp; {{ \Carbon\Carbon::parse($seminar->tanggal_acara)->format('d M Y') }}
                        </span>
                
                        <span class="flex items-center text-gray-500 bg-gray-100 px-2 py-1 rounded">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            {{ $seminar->views_count }}x Dilihat
                        </span>
                    </div>

                    <h3 class="text-lg font-semibold mb-2 text-gray-800">Deskripsi Materi:</h3>
                    <div class="text-gray-700 leading-relaxed mb-8 whitespace-pre-line">
                        {{ $seminar->deskripsi ?? 'Tidak ada deskripsi yang ditambahkan.' }}
                    </div>

                    @if($seminar->file_modul)
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="flex items-center">
                                <svg class="w-10 h-10 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path></svg>
                                <div>
                                    <p class="font-semibold text-gray-800">Modul / Slide Presentasi</p>
                                    <p class="text-xs text-gray-500">Klik tombol untuk mengunduh materi.</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $seminar->file_modul) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow-sm transition duration-150 w-full sm:w-auto text-center">
                                Unduh PDF
                            </a>
                        </div>
                    @endif
                    @php
                        $isBookmarked = auth()->user()->bookmarks->contains($seminar->id);
                    @endphp
                    
                    <form action="{{ route('seminar.bookmark', $seminar->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                            class="flex items-center px-4 py-2 rounded-lg font-bold shadow transition duration-150
                            {{ $isBookmarked ? 'bg-yellow-100 text-yellow-700 border border-yellow-400' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 border border-gray-300' }}">
                            
                            <svg class="w-5 h-5 mr-2 {{ $isBookmarked ? 'fill-current' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24" fill="none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                            
                            {{ $isBookmarked ? 'Disimpan' : 'Simpan ke Koleksi' }}
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>