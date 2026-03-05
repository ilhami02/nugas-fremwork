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

                    <!-- @if(auth()->user()->is_admin)
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
        <a href="{{ route('seminar.edit', $seminar->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded">
            Edit Konten
        </a>
    </div>
    @endif -->

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
                    <div class="my-8 bg-yellow-50 border border-yellow-200 rounded-lg p-6 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm">
    
    <div class="flex items-center">
        <div class="text-4xl font-black text-yellow-500 mr-4">
            {{ $seminar->averageRating() }}
        </div>
        <div>
            <div class="flex text-yellow-400 text-xl">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= round($seminar->averageRating()))
                        ★
                    @else
                        <span class="text-gray-300">★</span>
                    @endif
                @endfor
            </div>
            <p class="text-sm text-gray-500 font-medium mt-1">Berdasarkan {{ $seminar->ratings->count() }} penilaian user</p>
        </div>
    </div>

    <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm w-full md:w-auto text-center">
        <p class="text-xs text-gray-600 font-bold mb-2 uppercase tracking-wider">Beri Penilaian Anda</p>
        <form action="{{ route('rating.store', $seminar->id) }}" method="POST" class="flex items-center justify-center gap-2">
            @csrf
            
            @php
                $userRating = $seminar->ratings->where('user_id', auth()->id())->first();
                $currentScore = $userRating ? $userRating->score : 0;
            @endphp

            @for($i = 1; $i <= 5; $i++)
                <button type="submit" name="score" value="{{ $i }}" 
                        class="text-2xl transition hover:scale-125 focus:outline-none {{ $i <= $currentScore ? 'text-yellow-400' : 'text-gray-300 hover:text-yellow-300' }}"
                        title="Beri nilai {{ $i }} Bintang">
                    ★
                </button>
            @endfor
        </form>
    </div>
    
</div>
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
                <div class="prose max-w-none text-gray-800 font-sans">
                    {!! Illuminate\Support\Str::markdown($seminar->rangkuman_ai) !!}
                </div>
                <div class="mt-4 flex items-center text-xs text-purple-600 italic">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Terverifikasi oleh AI System
                </div>
                <button onclick="copyNotulen()" class="mt-4 text-sm flex items-center text-purple-700 hover:text-purple-900 font-medium">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Salin Notulen
                </button>
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
        <div class="mt-12 pt-8 border-t border-gray-200">
    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
        Ruang Diskusi & Q&A ({{ $seminar->discussions->count() }} Pesan)
    </h3>

    <div class="bg-gray-50 rounded-lg p-6 mb-8 border border-gray-200 shadow-sm">
        <form action="{{ route('diskusi.store', $seminar->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="body" class="block text-sm font-medium text-gray-700 mb-2">Punya pertanyaan tentang materi ini? Tulis di sini!</label>
                <textarea name="body" rows="3" required placeholder="Ketik pertanyaan atau tanggapan Anda..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md shadow transition duration-150 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Kirim Pesan
                </button>
            </div>
        </form>
    </div>

    <div class="space-y-6">
        @forelse($seminar->discussions->whereNull('parent_id') as $diskusi)
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex gap-4">
                <div class="flex-shrink-0 mt-1">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow">
                        {{ substr($diskusi->user->name, 0, 1) }}
                    </div>
                </div>
                
                <div class="flex-grow">
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="text-md font-bold text-gray-900">
                            {{ $diskusi->user->name }}
                            @if($diskusi->user->is_admin)
                                <span class="ml-2 bg-purple-100 text-purple-800 text-xs font-semibold px-2 py-0.5 rounded border border-purple-200">Admin</span>
                            @endif
                        </h4>
                        <span class="text-xs text-gray-500">{{ $diskusi->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <p class="text-gray-700 whitespace-pre-line mb-3">{{ $diskusi->body }}</p>

                    <button type="button" onclick="toggleReplyForm('reply-form-{{ $diskusi->id }}')" class="text-sm text-blue-600 hover:text-blue-800 font-semibold flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                        Balas Diskusi Ini
                    </button>

                    <div id="reply-form-{{ $diskusi->id }}" class="hidden mt-4 bg-gray-50 p-4 rounded border border-gray-200">
                        <form action="{{ route('diskusi.store', $seminar->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $diskusi->id }}">
                            <textarea name="body" rows="2" required placeholder="Tulis balasan Anda..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm mb-3"></textarea>
                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="toggleReplyForm('reply-form-{{ $diskusi->id }}')" class="text-gray-600 hover:text-gray-800 text-sm font-medium px-3 py-1">Batal</button>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-1 px-4 rounded shadow">Kirim Balasan</button>
                            </div>
                        </form>
                    </div>

                    @if($diskusi->replies->count() > 0)
                        <div class="mt-5 space-y-4 border-l-2 border-blue-200 pl-4 ml-2">
                            @foreach($diskusi->replies as $reply)
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 flex gap-3">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 font-bold text-sm">
                                            {{ substr($reply->user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex justify-between items-center mb-1">
                                            <h5 class="text-sm font-bold text-gray-900">
                                                {{ $reply->user->name }}
                                                @if($reply->user->is_admin)
                                                    <span class="ml-2 bg-purple-100 text-purple-800 text-[10px] font-semibold px-2 py-0.5 rounded">Admin</span>
                                                @endif
                                            </h5>
                                            <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-700 text-sm whitespace-pre-line">{{ $reply->body }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                Belum ada diskusi. Jadilah yang pertama memulai topik!
            </div>
        @endforelse
    </div>
</div>
</div>
</x-app-layout>

<script>
function copyNotulen() {
    const text = `{!! addslashes($seminar->rangkuman_ai) !!}`;
    navigator.clipboard.writeText(text);
    }

    function toggleReplyForm(formId) {
        const form = document.getElementById(formId);
        if (form.classList.contains('hidden')) {
            form.classList.remove('hidden');
        } else {
            form.classList.add('hidden');
        }
    }
</script>
