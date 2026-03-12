<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                {{ __('Edit Konten Seminar (Admin)') }}
            </h2>
            <a href="{{ route('seminar.show', $seminar->id) }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm">
                &larr; Batal & Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>- {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('seminar.update', $seminar->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Method PUT wajib untuk proses Edit/Update di Laravel --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="md:col-span-2">
                                <label for="judul" class="block text-sm font-medium text-gray-700">Judul Seminar</label>
                                <input type="text" name="judul" id="judul" value="{{ old('judul', $seminar->judul) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="pembicara" class="block text-sm font-medium text-gray-700">Nama Pembicara</label>
                                <input type="text" name="pembicara" id="pembicara" value="{{ old('pembicara', $seminar->pembicara) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="kategori_prodi" class="block text-sm font-medium text-gray-700">Kategori / Prodi</label>
                                <select name="kategori_prodi" id="kategori_prodi" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="Teknik Informatika" {{ $seminar->kategori_prodi == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                    <option value="Teknik Mesin" {{ $seminar->kategori_prodi == 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                                    <option value="Teknik Listrik" {{ $seminar->kategori_prodi == 'Teknik Listrik' ? 'selected' : '' }}>Teknik Listrik</option>
                                    <option value="Teknik Elektronika" {{ $seminar->kategori_prodi == 'Teknik Elektronika' ? 'selected' : '' }}>Teknik Elektronika</option>
                                    <option value="Umum" {{ $seminar->kategori_prodi == 'Umum' ? 'selected' : '' }}>Umum</option>
                                </select>
                            </div>

                            <div>
                                <label for="tanggal_acara" class="block text-sm font-medium text-gray-700">Tanggal Acara</label>
                                <input type="date" name="tanggal_acara" id="tanggal_acara" value="{{ old('tanggal_acara', $seminar->tanggal_acara) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="url_video" class="block text-sm font-medium text-gray-700">URL Video YouTube (Opsional)</label>
                                <input type="url" name="url_video" id="url_video" value="{{ old('url_video', $seminar->url_video) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="https://youtube.com/watch?v=...">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('deskripsi', $seminar->deskripsi) }}</textarea>
                        </div>

                        <div class="mb-8 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                            <label for="file_modul" class="block text-sm font-medium text-gray-700">Ganti File Modul (PDF/PPT) - Kosongkan jika tidak ingin diganti</label>
                            <input type="file" name="file_modul" id="file_modul" accept=".pdf,.ppt,.pptx" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @if($seminar->file_modul)
                                <p class="mt-2 text-xs text-gray-500">File saat ini: <a href="{{ asset('storage/' . $seminar->file_modul) }}" target="_blank" class="text-blue-600 underline">Lihat File</a></p>
                            @endif
                        </div>

                        <div class="bg-white p-6 rounded-xl border border-gray-200 mt-6 shadow-sm">
                            <h3 class="font-bold text-lg text-campus-blue mb-4">Upload Voice</h3>

                            <form action="{{ route('seminar.upload_voice', $seminar->id) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-4">
                                @csrf
                                <div class="flex-1">
                                    <input type="file" name="voice_file" accept=".mp3,.wav,.m4a,.ogg" required
                                            class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring focus:ring-campus-blue/20">
                                    <p class="text-xs text-gray-500 mt-1">Format: MP3, WAV, M4A. Maksimal 20MB.</p>
                                </div>
                                <button type="submit" 
                                        class="bg-campus-blue hover:bg-campus-blue-d text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition">
                                    Upload & Generate Notulen
                                </button>
                            </form>
                        </div>

                        <hr class="my-8 border-gray-200">


                        <div class="mb-8">
                            <label for="rangkuman_ai" class="flex items-center text-lg font-bold text-purple-700 mb-2">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                Editor Notulen
                            </label>
                            <p class="text-sm text-gray-500 mb-3">Sebagai Admin, Anda dapat merapikan, menghapus kata yang salah, atau menambahkan poin penting yang terlewat oleh AI sebelum dipublikasikan ke user.</p>
                            
                            <textarea name="rangkuman_ai" id="rangkuman_ai" rows="12" class="mt-1 block w-full rounded-md border-purple-300 bg-purple-50 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-gray-800 leading-relaxed">{{ old('rangkuman_ai', $seminar->rangkuman_ai) }}</textarea>
                        </div>

                        <div class="flex justify-end gap-4">
                            <a href="{{ route('seminar.show', $seminar->id) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition duration-200">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-200 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>