<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-base" style="color: #0f2c5e;">Tambah Arsip Seminar Baru</h2>
            <a href="{{ route('seminar.index') }}" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="campus-card overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100" style="background: linear-gradient(90deg, #0f2c5e, #1a4080);">
                <h3 class="font-semibold text-white text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Formulir Arsip Seminar
                </h3>
            </div>
            <div class="p-6">
                <form action="{{ route('seminar.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold mb-1.5" style="color: #0f2c5e;">Judul Seminar <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" class="campus-input" placeholder="Masukkan judul seminar" required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1.5" style="color: #0f2c5e;">Nama Pembicara <span class="text-red-500">*</span></label>
                        <input type="text" name="pembicara" class="campus-input" placeholder="Nama lengkap pembicara" required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1.5" style="color: #0f2c5e;">Kategori / Program Studi <span class="text-red-500">*</span></label>
                        <select name="kategori_prodi" class="campus-input" required>
                            <option value="">-- Pilih Program Studi --</option>
                            <option value="Teknik Informatika">Teknik Informatika</option>
                            <option value="Teknik Mesin">Teknik Mesin</option>
                            <option value="Teknik Elektronika">Teknik Elektronika</option>
                            <option value="Umum">Umum / Semua Jurusan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1.5" style="color: #0f2c5e;">Tanggal Pelaksanaan <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_acara" class="campus-input" required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1.5" style="color: #0f2c5e;">Deskripsi Ringkas <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <textarea name="deskripsi" rows="4" class="campus-input" style="resize:vertical;" placeholder="Ringkasan singkat tentang seminar..."></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1.5" style="color: #0f2c5e;">URL Video YouTube <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <input type="url" name="url_video" placeholder="https://youtube.com/embed/..." class="campus-input">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1.5" style="color: #0f2c5e;">Upload Modul / Materi <span class="text-gray-400 font-normal">(PDF/PPT, Opsional)</span></label>
                        <div class="border-2 border-dashed border-gray-200 rounded-lg p-4 text-center hover:border-blue-300 transition">
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            <input type="file" name="file_modul" accept=".pdf,.ppt,.pptx" class="text-sm text-gray-500">
                            <p class="text-xs text-gray-400 mt-1">PDF, PPT, atau PPTX</p>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-gray-100 flex gap-3">
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                            Simpan Arsip
                        </button>
                        <a href="{{ route('seminar.index') }}" class="btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>