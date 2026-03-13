<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-base text-campus-blue">Detail Materi Seminar</h2>
            <div class="flex items-center gap-2">
                @if(auth()->user()->is_admin)
                <a href="{{ route('seminar.edit', $seminar->id) }}"
                   class="inline-flex items-center gap-1.5 bg-campus-orange/10 hover:bg-campus-orange/20 text-campus-orange border border-campus-orange/30 px-4 py-2 rounded-lg text-sm font-semibold transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Seminar
                </a>
                @endif
                <a href="{{ route('seminar.index') }}"
                   class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-campus-dark border border-campus-gray/50 px-4 py-2 rounded-lg text-sm font-semibold transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div data-alert class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm flex items-center gap-2 mb-4">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div data-alert class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm flex items-center gap-2 mb-4">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <strong>Gagal!</strong> {{ session('error') }}
        </div>
    @endif

    {{-- Layout 2 Kolom --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; align-items: start;">

        {{-- ======== KOLOM KIRI ======== --}}
        <div style="position: sticky; top: 1.5rem;">

            {{-- Card utama: video + info --}}
            <div class="bg-white border border-campus-gray/40 rounded-xl shadow-sm overflow-hidden mb-5">

                {{-- Video / Thumbnail --}}
                @if($seminar->url_video)
                    @php
                        preg_match('/(?:v=|\/embed\/|\.be\/)([a-zA-Z0-9_-]{11})/', $seminar->url_video, $m);
                        $ytId = $m[1] ?? null;
                    @endphp
                    @if($ytId)
                        <div style="position:relative; width:100%; padding-bottom:56.25%; background:#000;">
                            <iframe style="position:absolute;top:0;left:0;width:100%;height:100%;"
                                    src="https://www.youtube.com/embed/{{ $ytId }}"
                                    title="Video Seminar" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @else
                        <div style="width:100%;aspect-ratio:16/9;background:#000;">
                            <iframe style="width:100%;height:100%;" src="{{ $seminar->url_video }}" title="Video" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @endif
                @else
                    <div class="w-full h-40 flex flex-col items-center justify-center bg-campus-blue">
                        <svg class="w-10 h-10 mb-2 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.883v6.234a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <span class="text-sm text-white/40">Video rekaman tidak tersedia</span>
                    </div>
                @endif

                <div class="p-5">
                    {{-- Badge & Meta --}}
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        <span class="inline-block bg-campus-blue/10 text-campus-blue text-[0.7rem] font-bold px-2.5 py-1 rounded-full tracking-wide uppercase">
                            {{ $seminar->kategori_prodi }}
                        </span>
                        <span class="text-xs text-gray-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            {{ $seminar->views_count }}x dilihat
                        </span>
                    </div>

                    <h1 class="text-xl font-bold mb-3 text-campus-dark">{{ $seminar->judul }}</h1>

                    <div class="flex flex-wrap gap-x-5 gap-y-1.5 text-sm text-gray-400 mb-5 pb-5 border-b border-campus-gray/30">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <strong class="text-campus-dark">Pembicara:</strong> {{ $seminar->pembicara }}
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <strong class="text-campus-dark">Tanggal:</strong> {{ \Carbon\Carbon::parse($seminar->tanggal_acara)->format('d M Y') }}
                        </span>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-5">
                        <h3 class="flex items-center gap-2 text-sm font-bold text-campus-blue mb-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                            Deskripsi Materi
                        </h3>
                        @php $desc = $seminar->deskripsi ?? ''; $descLong = strlen($desc) > 200; @endphp
                        <div class="relative">
                            <div id="desc-preview" class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $descLong ? Str::limit($desc, 200) : ($desc ?: 'Tidak ada deskripsi yang ditambahkan.') }}</div>
                            <div id="desc-full" class="text-sm text-gray-600 leading-relaxed whitespace-pre-line" style="display:none;">{{ $desc }}</div>
                            @if($descLong)
                                <div id="desc-fade" style="position:absolute;bottom:0;left:0;right:0;height:40px;background:linear-gradient(to bottom,transparent,white);pointer-events:none;"></div>
                            @endif
                        </div>
                        @if($descLong)
                            <button id="desc-more-btn" onclick="toggleDesc()"
                                    class="mt-2 inline-flex items-center gap-1 text-xs font-semibold text-campus-blue hover:text-campus-blue-d border border-campus-blue/20 hover:border-campus-blue/50 bg-campus-blue/5 hover:bg-campus-blue/10 px-3 py-1.5 rounded-lg transition">
                                <svg id="desc-more-icon" class="w-3.5 h-3.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                <span id="desc-more-text">Baca Selengkapnya</span>
                            </button>
                        @endif
                    </div>

                    {{-- File Modul --}}
                    @if($seminar->file_modul)
                        <div class="rounded-xl p-4 flex flex-col sm:flex-row items-center justify-between gap-3 mb-5 bg-gray-50 border border-campus-gray/30">
                            <div class="flex items-center gap-3">
                                <div class="p-2.5 rounded-lg bg-red-50">
                                    <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/></svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-sm text-campus-dark">Modul / Slide Presentasi</p>
                                    <p class="text-xs text-gray-400">Klik tombol untuk mengunduh</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $seminar->file_modul) }}" target="_blank"
                               class="inline-flex items-center gap-1.5 bg-campus-blue hover:bg-campus-blue-d text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm w-full sm:w-auto justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Unduh PDF
                            </a>
                        </div>
                    @endif

                    {{-- Rating + Bookmark --}}
                    <div class="flex flex-col gap-3">
                        {{-- Rating --}}
                        <div class="rounded-xl p-4 flex items-center justify-between bg-campus-orange/5 border border-campus-orange/20">
                            <div class="flex items-center gap-3">
                                <div id="avg-rating-num" class="text-3xl font-black text-campus-orange">{{ $seminar->averageRating() }}</div>
                                <div>
                                    <div id="avg-stars" class="flex text-campus-orange text-lg">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= round($seminar->averageRating()))
                                                <span>★</span>
                                            @else
                                                <span class="text-campus-gray">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="text-xs text-gray-400 mt-0.5"><span id="rating-count">{{ $seminar->ratings->count() }}</span> penilaian</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-semibold text-gray-500 mb-1.5">Beri Nilai:</p>
                                @php
                                    $userRating = $seminar->ratings->where('user_id', auth()->id())->first();
                                    $currentScore = $userRating ? $userRating->score : 0;
                                @endphp
                                <form id="rating-form"
                                      action="{{ route('rating.store', $seminar->id) }}"
                                      method="POST"
                                      class="flex items-center gap-1"
                                      data-avg="{{ $seminar->averageRating() }}"
                                      data-count="{{ $seminar->ratings->count() }}"
                                      data-user-score="{{ $currentScore }}">
                                    @csrf
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="submit" name="score" value="{{ $i }}"
                                                class="text-xl transition hover:scale-125 focus:outline-none {{ $i <= $currentScore ? 'text-campus-orange' : 'text-campus-gray hover:text-campus-orange' }}"
                                                title="Beri nilai {{ $i }} Bintang">★</button>
                                    @endfor
                                </form>
                            </div>
                        </div>

                        {{-- Bookmark --}}
                        @php $isBookmarked = auth()->user()->bookmarks->contains($seminar->id); @endphp
                        <form id="bookmark-form" action="{{ route('seminar.bookmark', $seminar->id) }}" method="POST">
                            @csrf
                            <button type="submit" id="bookmark-btn"
                                data-bookmarked="{{ $isBookmarked ? 'true' : 'false' }}"
                                class="w-full rounded-xl px-5 py-3 font-semibold text-sm flex items-center justify-center gap-2 transition border
                                {{ $isBookmarked
                                    ? 'bg-campus-orange/10 text-campus-orange border-campus-orange/30'
                                    : 'bg-gray-50 text-gray-500 hover:bg-gray-100 border-campus-gray/40' }}">
                                <svg id="bookmark-icon" class="w-5 h-5" stroke="currentColor" viewBox="0 0 24 24" fill="{{ $isBookmarked ? 'currentColor' : 'none' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                                <span id="bookmark-text">{{ $isBookmarked ? 'Tersimpan' : 'Simpan ke Koleksi' }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Kolom Kiri --}}

        {{-- ======== KOLOM KANAN ======== --}}
        <div class="space-y-5">

            {{-- Card: Rangkuman AI --}}
            <div class="bg-white border border-campus-gray/40 rounded-xl shadow-sm overflow-hidden">
                <div class="px-5 py-3 flex items-center justify-between bg-purple-700">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        <h3 class="text-sm font-semibold text-white">Rangkuman</h3>
                    </div>
                    @if($seminar->rangkuman_ai)
                        <button onclick="copyNotulen()" class="text-xs flex items-center gap-1 text-purple-200 hover:text-white font-medium transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                            Salin Notulen
                        </button>
                    @endif
                </div>

                <div class="p-5">
                    @if($seminar->rangkuman_ai)
                        {{-- Konten Rangkuman --}}
                        <div id="rangkuman-wrapper" class="relative">
                            {{-- Preview (terpotong) --}}
                            <div id="rangkuman-preview" class="prose max-w-none text-gray-700 text-sm leading-relaxed">
                                {!! Illuminate\Support\Str::markdown(Str::limit($seminar->rangkuman_ai, 600)) !!}
                            </div>
                            {{-- Full content (tersembunyi awalnya) --}}
                            <div id="rangkuman-full" class="prose max-w-none text-gray-700 text-sm leading-relaxed" style="display:none;">
                                {!! Illuminate\Support\Str::markdown($seminar->rangkuman_ai) !!}
                            </div>
                            {{-- Fade overlay saat collapsed --}}
                            <div id="rangkuman-fade"
                                 style="position:absolute; bottom:0; left:0; right:0; height:80px;
                                        background: linear-gradient(to bottom, transparent, white);
                                        pointer-events:none;">
                            </div>
                        </div>

                        {{-- Tombol Read More --}}
                        @if(strlen($seminar->rangkuman_ai) > 600)
                            <div class="mt-3 text-center">
                                <button id="read-more-btn" onclick="toggleReadMore()"
                                        class="inline-flex items-center gap-1.5 text-purple-700 hover:text-purple-900 text-sm font-semibold border border-purple-200 hover:border-purple-400 bg-purple-50 hover:bg-purple-100 px-4 py-2 rounded-lg transition">
                                    <svg id="read-more-icon" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    <span id="read-more-text">Baca Selengkapnya</span>
                                </button>
                            </div>
                        @endif

                        <div class="flex items-center gap-4 pt-3 mt-3 border-t border-campus-gray/30">
                            <span class="flex items-center gap-1 text-xs text-purple-600">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Terverifikasi oleh AI System
                            </span>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                            <p class="text-sm text-gray-400">Belum ada rangkuman modul untuk seminar ini.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Card: Ruang Diskusi --}}
            <div class="bg-white border border-campus-gray/40 rounded-xl shadow-sm p-5">
                <h3 class="flex items-center gap-2 text-base font-bold text-campus-blue mb-5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>
                    Ruang Diskusi &amp; Q&amp;A
                    <span class="text-xs font-normal text-gray-400">({{ $seminar->discussions->count() }} pesan)</span>
                </h3>

                {{-- Form Tulis Pesan --}}
                <div class="rounded-xl p-4 mb-5 bg-gray-50 border border-campus-gray/30">
                    <form action="{{ route('diskusi.store', $seminar->id) }}" method="POST" data-diskusi>
                        @csrf
                        <div class="mb-3">
                            <label class="block text-xs font-semibold mb-1.5 text-campus-blue">Tulis pertanyaan atau komentar:</label>
                            <textarea name="body" rows="3" required placeholder="Ketik pertanyaan atau tanggapan Anda..."
                                      class="w-full border border-campus-gray/60 rounded-lg px-3.5 py-2 text-sm text-campus-dark bg-white outline-none transition focus:border-campus-blue focus:ring-2 focus:ring-campus-blue/15"
                                      style="resize:vertical;"></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 bg-campus-blue hover:bg-campus-blue-d text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Daftar Pesan --}}
                <div class="space-y-4">
                    @forelse($seminar->discussions->whereNull('parent_id') as $diskusi)
                        <div class="bg-white border border-campus-gray/30 rounded-xl p-4 flex gap-3">
                            <div class="flex-shrink-0">
                                <div class="h-9 w-9 rounded-full flex items-center justify-center text-white font-bold text-sm shadow bg-campus-blue">
                                    {{ substr($diskusi->user->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-campus-dark">{{ $diskusi->user->name }}</span>
                                        @if($diskusi->user->is_admin)
                                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-campus-orange/10 text-campus-orange">Admin</span>
                                        @endif
                                    </div>
                                    <span class="text-xs text-gray-400">{{ $diskusi->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-600 whitespace-pre-line mb-2">{{ $diskusi->body }}</p>
                                <button type="button" onclick="toggleReplyForm('reply-form-{{ $diskusi->id }}')"
                                        class="text-xs font-semibold flex items-center gap-1 text-campus-blue hover:text-campus-blue-d transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                    Balas
                                </button>

                                <div id="reply-form-{{ $diskusi->id }}" class="hidden mt-3 p-3 rounded-lg bg-gray-50 border border-campus-gray/30">
                                    <form action="{{ route('diskusi.store', $seminar->id) }}" method="POST" data-diskusi>
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $diskusi->id }}">
                                        <textarea name="body" rows="2" required placeholder="Tulis balasan…"
                                                  class="w-full border border-campus-gray/60 rounded-lg px-3.5 py-2 text-sm text-campus-dark bg-white outline-none transition focus:border-campus-blue focus:ring-2 focus:ring-campus-blue/15 mb-2"
                                                  style="resize:vertical;"></textarea>
                                        <div class="flex justify-end gap-2">
                                            <button type="button" onclick="toggleReplyForm('reply-form-{{ $diskusi->id }}')" class="text-xs text-gray-400 hover:text-gray-600 px-3 py-1.5 rounded">Batal</button>
                                            <button type="submit" class="inline-flex items-center gap-1 bg-campus-blue hover:bg-campus-blue-d text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">Kirim Balasan</button>
                                        </div>
                                    </form>
                                </div>

                                @if($diskusi->replies->count() > 0)
                                    <div class="mt-3 space-y-3 border-l-2 border-campus-orange/40 pl-4 ml-1">
                                        @foreach($diskusi->replies as $reply)
                                            <div class="flex gap-2.5">
                                                <div class="h-7 w-7 rounded-full flex items-center justify-center text-white font-bold text-xs flex-shrink-0 bg-campus-gray">
                                                    {{ substr($reply->user->name, 0, 1) }}
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between mb-0.5">
                                                        <div class="flex items-center gap-1.5">
                                                            <span class="text-xs font-bold text-campus-dark">{{ $reply->user->name }}</span>
                                                            @if($reply->user->is_admin)
                                                                <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded-full bg-campus-orange/10 text-campus-orange">Admin</span>
                                                            @endif
                                                        </div>
                                                        <span class="text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-xs text-gray-600 whitespace-pre-line">{{ $reply->body }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-sm text-gray-400 rounded-xl border border-dashed border-campus-gray/50 bg-gray-50">
                            Belum ada diskusi. Jadilah yang pertama memulai topik!
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
        {{-- End Kolom Kanan --}}

    </div>
    {{-- End 2-Kolom --}}

</x-app-layout>

<script>
// ── Read More Toggle (Rangkuman) ──────────────────────────
function toggleReadMore() {
    const preview  = document.getElementById('rangkuman-preview');
    const full     = document.getElementById('rangkuman-full');
    const fade     = document.getElementById('rangkuman-fade');
    const icon     = document.getElementById('read-more-icon');
    const label    = document.getElementById('read-more-text');
    const isOpen   = full.style.display !== 'none';

    if (isOpen) {
        full.style.display    = 'none';
        preview.style.display = '';
        if (fade) fade.style.display = '';
        icon.style.transform  = 'rotate(0deg)';
        label.textContent     = 'Baca Selengkapnya';
    } else {
        preview.style.display = 'none';
        full.style.display    = '';
        if (fade) fade.style.display = 'none';
        icon.style.transform  = 'rotate(180deg)';
        label.textContent     = 'Sembunyikan';
    }
}

// ── Read More Toggle (Deskripsi) ──────────────────────────
function toggleDesc() {
    const preview = document.getElementById('desc-preview');
    const full    = document.getElementById('desc-full');
    const fade    = document.getElementById('desc-fade');
    const icon    = document.getElementById('desc-more-icon');
    const label   = document.getElementById('desc-more-text');
    const isOpen  = full.style.display !== 'none';

    if (isOpen) {
        full.style.display    = 'none';
        preview.style.display = '';
        if (fade) fade.style.display = '';
        icon.style.transform  = 'rotate(0deg)';
        label.textContent     = 'Baca Selengkapnya';
    } else {
        preview.style.display = 'none';
        full.style.display    = '';
        if (fade) fade.style.display = 'none';
        icon.style.transform  = 'rotate(180deg)';
        label.textContent     = 'Sembunyikan';
    }
}

// ── Copy Notulen ──────────────────────────────────────────
function copyNotulen() {
    const text = `{!! addslashes($seminar->rangkuman_ai) !!}`;
    navigator.clipboard.writeText(text);
    alert('Notulen berhasil disalin!');
}

// ── Toggle Reply Form ─────────────────────────────────────
function toggleReplyForm(formId) {
    document.getElementById(formId).classList.toggle('hidden');
}

document.addEventListener('DOMContentLoaded', function () {

    // ── Anti-spam diskusi ──────────────────────────────────────
    document.querySelectorAll('form[data-diskusi]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (form.dataset.submitting === 'true') { e.preventDefault(); return; }
            const textarea = form.querySelector('textarea[name="body"]');
            if (textarea && textarea.value.trim() === '') { e.preventDefault(); return; }
            form.dataset.submitting = 'true';
            const btn = form.querySelector('button[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.classList.add('opacity-60', 'cursor-not-allowed');
                btn.innerHTML = `<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 22 6.477 22 12h-4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengirim...`;
            }
        });
    });

    // ── Rating AJAX ────────────────────────────────────────────
    const ratingForm = document.getElementById('rating-form');
    if (ratingForm) {
        ratingForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const score = e.submitter ? parseInt(e.submitter.value) : null;
            if (!score) return;
            const csrf = ratingForm.querySelector('[name=_token]').value;

            let oldAvg   = parseFloat(ratingForm.dataset.avg)    || 0;
            let oldCount = parseInt(ratingForm.dataset.count)    || 0;
            let oldUser  = parseInt(ratingForm.dataset.userScore) || 0;

            try {
                await fetch(ratingForm.action, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
                    body: `_token=${encodeURIComponent(csrf)}&score=${score}`
                });

                let newAvg, newCount;
                if (oldUser === 0) {
                    newCount = oldCount + 1;
                    newAvg   = (oldAvg * oldCount + score) / newCount;
                } else {
                    newCount = oldCount;
                    newAvg   = (oldAvg * oldCount - oldUser + score) / newCount;
                }
                newAvg = Math.round(newAvg * 10) / 10;

                ratingForm.dataset.avg       = newAvg;
                ratingForm.dataset.count     = newCount;
                ratingForm.dataset.userScore = score;

                document.getElementById('avg-rating-num').textContent = newAvg.toFixed(1);
                document.getElementById('rating-count').textContent   = newCount;

                const avgStars = document.getElementById('avg-stars');
                if (avgStars) {
                    avgStars.innerHTML = '';
                    for (let i = 1; i <= 5; i++) {
                        const span = document.createElement('span');
                        span.textContent = '★';
                        span.className = i <= Math.round(newAvg) ? '' : 'text-campus-gray';
                        avgStars.appendChild(span);
                    }
                }

                ratingForm.querySelectorAll('button[name=score]').forEach(function (btn) {
                    const val = parseInt(btn.value);
                    btn.classList.remove('text-campus-orange', 'text-campus-gray', 'hover:text-campus-orange');
                    if (val <= score) {
                        btn.classList.add('text-campus-orange');
                    } else {
                        btn.classList.add('text-campus-gray', 'hover:text-campus-orange');
                    }
                });

            } catch (err) { console.error('Rating error:', err); }
        });
    }

    // ── Bookmark AJAX ──────────────────────────────────────────
    const bookmarkForm = document.getElementById('bookmark-form');
    if (bookmarkForm) {
        bookmarkForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const btn   = document.getElementById('bookmark-btn');
            const icon  = document.getElementById('bookmark-icon');
            const label = document.getElementById('bookmark-text');
            const csrf  = bookmarkForm.querySelector('[name=_token]').value;
            const wasBookmarked = btn.dataset.bookmarked === 'true';
            try {
                await fetch(bookmarkForm.action, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
                    body: `_token=${encodeURIComponent(csrf)}`
                });
                const nowBookmarked = !wasBookmarked;
                btn.dataset.bookmarked = nowBookmarked.toString();
                if (nowBookmarked) {
                    btn.classList.remove('bg-gray-50','text-gray-500','hover:bg-gray-100','border-campus-gray/40');
                    btn.classList.add('bg-campus-orange/10','text-campus-orange','border-campus-orange/30');
                    icon.setAttribute('fill', 'currentColor');
                    label.textContent = 'Tersimpan';
                } else {
                    btn.classList.remove('bg-campus-orange/10','text-campus-orange','border-campus-orange/30');
                    btn.classList.add('bg-gray-50','text-gray-500','hover:bg-gray-100','border-campus-gray/40');
                    icon.setAttribute('fill', 'none');
                    label.textContent = 'Simpan ke Koleksi';
                }
            } catch (err) { console.error('Bookmark error:', err); }
        });
    }

});
</script>
