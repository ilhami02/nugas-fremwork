<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-base flex items-center gap-2 text-campus-blue">
                <svg class="w-5 h-5 text-campus-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Konten Seminar (Admin)
            </h2>
            <a href="{{ route('seminar.show', $seminar->id) }}" class="text-sm text-gray-400 hover:text-campus-blue transition flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Batal & Kembali
            </a>
        </div>
    </x-slot>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm mb-6">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form utama untuk update data seminar --}}
    <form id="form-edit-seminar" action="{{ route('seminar.update', $seminar->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Layout 2 Kolom --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; align-items: start;">

            {{-- ======== KOLOM KIRI: Data Seminar ======== --}}
            <div class="space-y-5">

                {{-- Card: Info Dasar Seminar --}}
                <div class="bg-white border border-campus-gray/40 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-campus-gray/30 flex items-center gap-2">
                        <svg class="w-4 h-4 text-campus-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <h3 class="font-bold text-sm text-campus-blue">Informasi Seminar</h3>
                    </div>
                    <div class="p-5 space-y-4">
                        <div>
                            <label for="judul" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Judul Seminar</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul', $seminar->judul) }}" required
                                   class="block w-full rounded-lg border-campus-gray/50 shadow-sm focus:border-campus-blue focus:ring-campus-blue text-sm">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="pembicara" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Nama Pembicara</label>
                                <input type="text" name="pembicara" id="pembicara" value="{{ old('pembicara', $seminar->pembicara) }}" required
                                       class="block w-full rounded-lg border-campus-gray/50 shadow-sm focus:border-campus-blue focus:ring-campus-blue text-sm">
                            </div>
                            <div>
                                <label for="tanggal_acara" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Tanggal Acara</label>
                                <input type="date" name="tanggal_acara" id="tanggal_acara" value="{{ old('tanggal_acara', $seminar->tanggal_acara) }}" required
                                       class="block w-full rounded-lg border-campus-gray/50 shadow-sm focus:border-campus-blue focus:ring-campus-blue text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="kategori_prodi" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Kategori / Prodi</label>
                            <select name="kategori_prodi" id="kategori_prodi" required
                                    class="block w-full rounded-lg border-campus-gray/50 shadow-sm focus:border-campus-blue focus:ring-campus-blue text-sm">
                                <option value="Teknik Informatika" {{ $seminar->kategori_prodi == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                <option value="Teknik Mesin"       {{ $seminar->kategori_prodi == 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                                <option value="Teknik Listrik"     {{ $seminar->kategori_prodi == 'Teknik Listrik' ? 'selected' : '' }}>Teknik Listrik</option>
                                <option value="Teknik Elektronika" {{ $seminar->kategori_prodi == 'Teknik Elektronika' ? 'selected' : '' }}>Teknik Elektronika</option>
                                <option value="Umum"               {{ $seminar->kategori_prodi == 'Umum' ? 'selected' : '' }}>Umum</option>
                            </select>
                        </div>

                        <div>
                            <label for="url_video" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">URL Video YouTube <span class="text-gray-300 normal-case font-normal">(Opsional)</span></label>
                            <input type="url" name="url_video" id="url_video" value="{{ old('url_video', $seminar->url_video) }}"
                                   class="block w-full rounded-lg border-campus-gray/50 shadow-sm focus:border-campus-blue focus:ring-campus-blue text-sm"
                                   placeholder="https://youtube.com/watch?v=..."
                                   oninput="updateYoutubeThumbnail(this.value)">
                            {{-- Preview Thumbnail YouTube --}}
                            <div id="yt-preview" class="mt-3 rounded-lg overflow-hidden border border-campus-gray/30 bg-gray-50"
                                 style="{{ $seminar->url_video ? '' : 'display:none;' }}">
                                @php
                                    $ytId = null;
                                    if ($seminar->url_video) {
                                        preg_match('/(?:v=|\/embed\/|\.be\/)([a-zA-Z0-9_-]{11})/', $seminar->url_video, $m);
                                        $ytId = $m[1] ?? null;
                                    }
                                @endphp
                                <img id="yt-thumbnail"
                                     src="{{ $ytId ? 'https://img.youtube.com/vi/'.$ytId.'/hqdefault.jpg' : '' }}"
                                     alt="YouTube Thumbnail"
                                     class="w-full object-cover"
                                     style="max-height: 160px; object-fit: cover;">
                                <div class="px-3 py-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                    <a id="yt-link" href="{{ $seminar->url_video ?? '#' }}" target="_blank"
                                       class="text-xs text-campus-blue hover:underline truncate">
                                        {{ $seminar->url_video ?? '' }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <script>
                        function updateYoutubeThumbnail(url) {
                            const preview = document.getElementById('yt-preview');
                            const thumb   = document.getElementById('yt-thumbnail');
                            const link    = document.getElementById('yt-link');
                            const match   = url.match(/(?:v=|\/embed\/|\.be\/)([a-zA-Z0-9_-]{11})/);
                            if (match) {
                                thumb.src  = 'https://img.youtube.com/vi/' + match[1] + '/hqdefault.jpg';
                                link.href  = url;
                                link.textContent = url;
                                preview.style.display = '';
                            } else {
                                preview.style.display = 'none';
                            }
                        }
                        </script>

                        <div>
                            <label for="deskripsi" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Deskripsi Singkat</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3"
                                      class="block w-full rounded-lg border-campus-gray/50 shadow-sm focus:border-campus-blue focus:ring-campus-blue text-sm">{{ old('deskripsi', $seminar->deskripsi) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Card: File Modul --}}
                <div class="bg-white border border-campus-gray/40 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-campus-gray/30 flex items-center gap-2">
                        <svg class="w-4 h-4 text-campus-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        <h3 class="font-bold text-sm text-campus-blue">File Modul</h3>
                    </div>
                    <div class="p-5">
                        <label for="file_modul" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">
                            Ganti File Modul (PDF/PPT) <span class="text-gray-300 normal-case font-normal">— Kosongkan jika tidak ingin diganti</span>
                        </label>
                        <input type="file" name="file_modul" id="file_modul" accept=".pdf,.ppt,.pptx"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-campus-blue/10 file:text-campus-blue hover:file:bg-campus-blue/20">
                        @if($seminar->file_modul)
                            <p class="mt-2 text-xs text-gray-500">
                                File saat ini:
                                <a href="{{ asset('storage/' . $seminar->file_modul) }}" target="_blank" class="text-campus-blue underline">Lihat File</a>
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Tombol Simpan (untuk kolom kiri agar mudah diakses) --}}
                <div class="flex justify-end gap-3">
                    <a href="{{ route('seminar.show', $seminar->id) }}"
                       class="inline-flex items-center gap-1.5 border border-campus-gray/50 text-gray-600 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 bg-campus-blue hover:bg-campus-blue-d text-white px-5 py-2 rounded-lg text-sm font-semibold transition shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>

            {{-- ======== KOLOM KANAN: Editor Notulen ======== --}}
            <div class="space-y-5">

                <!-- {{-- Card: Editor Notulen AI --}} -->
                <div class="bg-white border border-purple-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-purple-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        <h3 class="font-bold text-sm text-purple-700">Editor Notulen</h3>
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-gray-500 mb-3">Sebagai Admin, Anda dapat merapikan, menghapus kata yang salah, atau menambahkan poin penting sebelum dipublikasikan ke user.</p>
                        <textarea name="rangkuman_ai" id="rangkuman_ai" rows="16"
                                  class="block w-full rounded-lg border-purple-200 bg-purple-50 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm text-gray-800 leading-relaxed">{{ old('rangkuman_ai', $seminar->rangkuman_ai) }}</textarea>
                    </div>
                </div>

                {{-- Card: Tools Generate Notulen --}}
                <div class="bg-white border border-campus-gray/40 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-campus-gray/30 flex items-center gap-2">
                        <svg class="w-4 h-4 text-campus-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <h3 class="font-bold text-sm text-campus-blue">Generate Notulen Otomatis</h3>
                    </div>
                    <div class="p-5 space-y-4">

                        {{-- Upload Voice --}}
                        <div class="p-4 bg-campus-blue/5 border border-campus-blue/20 rounded-lg">
                            <p class="text-xs font-bold text-campus-blue uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
                                Upload File Audio
                            </p>
                            <form action="{{ route('seminar.upload_voice', $seminar->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                @csrf
                                <input type="file" name="voice_file" accept=".mp3,.wav,.m4a,.ogg"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-campus-blue/10 file:text-campus-blue hover:file:bg-campus-blue/20">
                                <p class="text-xs text-gray-400">Format: MP3, WAV, M4A, OGG. Maksimal 20MB.</p>
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 bg-campus-blue hover:bg-campus-blue-d text-white px-4 py-2 rounded-lg text-xs font-semibold transition w-full justify-center">
                                    Upload & Generate Notulen
                                </button>
                            </form>
                        </div>

                        {{-- Generate via YouTube --}}
                        <div class="p-4 bg-red-50 border border-red-100 rounded-lg">
                            <p class="text-xs font-bold text-red-600 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                Generate via YouTube URL
                            </p>
                            <p class="text-xs text-gray-500 mb-3">Gunakan URL YouTube yang sudah diisi di kolom kiri.</p>
                            <form action="{{ route('seminar.process_youtube', $seminar->id) }}" method="POST"
                                  onsubmit="return confirm('Sistem akan mencoba menganalisis video YouTube yang terlampir. Lanjutkan?');">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 bg-red-100 hover:bg-red-200 border border-red-200 hover:border-red-400 text-red-700 px-4 py-2 rounded-lg text-xs font-semibold transition w-full justify-center">
                                    Generate via YouTube URL
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
            {{-- End Kolom Kanan --}}

        </div>
    </form>

</x-app-layout>