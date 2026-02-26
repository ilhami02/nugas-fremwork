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

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        
        @if (session('error'))
             <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow-sm" role="alert">
                <strong class="font-bold">Gagal!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
    </div>
    <div class="py-12">

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
                    <div class="mt-8 mb-4 flex justify-center">
        <a href="{{ route('seminar.live', $seminar->id) }}" 
           class="group relative inline-flex items-center justify-center px-8 py-3 text-base font-bold text-white transition-all duration-200 bg-red-600 font-pj rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600 hover:bg-red-700 shadow-lg">
            
            <span class="absolute top-0 right-0 -mt-1 -mr-1 flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
            </span>

            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
            </svg>
            
            Mulai Live Notulen (Rekam Suara)
        </a>
    </div>

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

                    <div class="mt-8 pt-6 border-t border-gray-200">
        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            Modul Pintar (AI Agent)
        </h3>

        @if($seminar->rangkuman_ai)
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-6 shadow-sm">
                <div class="prose max-w-none text-gray-800 whitespace-pre-line font-sans">
                    {{ $seminar->rangkuman_ai }}
                </div>
                <div class="mt-4 flex items-center text-xs text-purple-600 italic">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Terverifikasi oleh AI System
                </div>
            </div>
        @else
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-lg p-8 text-center">
                <p class="text-gray-600 mb-4">Belum ada rangkuman modul otomatis. Gunakan AI Agent untuk menganalisis video ini.</p>
                
                <form action="{{ route('seminar.generate_ai', $seminar->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition duration-200 flex items-center mx-auto transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Generate Modul Sekarang
                    </button>
                </form>
            </div>
        @endif
    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
