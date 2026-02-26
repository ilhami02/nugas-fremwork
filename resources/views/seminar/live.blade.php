<x-app-layout>
    <x-slot name="header">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 mt-6">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Gagal!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Live Notulen: ') }} {{ $seminar->judul }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 text-center">
            
            <div id="statusArea" class="mb-8 p-6 bg-white shadow-sm rounded-lg border-2 border-dashed border-gray-300">
                <div id="recordingIcon" class="hidden mb-4">
                    <span class="relative flex h-8 w-8 mx-auto">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-8 w-8 bg-red-500"></span>
                    </span>
                    <p class="text-red-600 font-bold mt-2 animate-pulse">Sedang Merekam Suara...</p>
                </div>
                
                <p id="instruction" class="text-gray-500">Klik tombol di bawah untuk memulai pencatatan otomatis.</p>
            </div>

            <div class="flex justify-center gap-4">
                <button id="btnStart" class="bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-8 rounded-full shadow-lg flex items-center text-lg">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                    Mulai Rekam
                </button>

                <button id="btnStop" class="hidden bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-8 rounded-full shadow-lg flex items-center text-lg" disabled>
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path></svg>
                    Stop & Proses AI
                </button>
            </div>

            <form id="uploadForm" action="{{ route('seminar.process_audio', $seminar->id) }}" method="POST" enctype="multipart/form-data" class="hidden">
                @csrf
                <input type="file" name="audio_blob" id="audioInput">
            </form>

        </div>
    </div>

    <script>
        let mediaRecorder;
        let audioChunks = [];
        const btnStart = document.getElementById('btnStart');
        const btnStop = document.getElementById('btnStop');
        const recordingIcon = document.getElementById('recordingIcon');
        const instruction = document.getElementById('instruction');

        btnStart.addEventListener('click', async () => {
            // Minta izin microphone browser
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            mediaRecorder = new MediaRecorder(stream);

            mediaRecorder.start();

            // UI Updates
            btnStart.classList.add('hidden');
            btnStop.classList.remove('hidden');
            btnStop.disabled = false;
            recordingIcon.classList.remove('hidden');
            instruction.innerText = "Sistem sedang mendengarkan seminar...";

            mediaRecorder.addEventListener("dataavailable", event => {
                audioChunks.push(event.data);
            });

            mediaRecorder.addEventListener("stop", () => {
                // Gabungkan potongan audio menjadi satu file blob
                const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                
                // Masukkan ke input file tersembunyi
                const file = new File([audioBlob], "rekaman_seminar.webm", { type: "audio/webm" });
                const container = new DataTransfer();
                container.items.add(file);
                document.getElementById('audioInput').files = container.files;

                // Submit Form Otomatis
                instruction.innerText = "Sedang mengupload dan memproses dengan AI... Mohon tunggu.";
                recordingIcon.classList.add('hidden');
                document.getElementById('uploadForm').submit();
            });
        });

        btnStop.addEventListener('click', () => {
            mediaRecorder.stop();
            btnStop.disabled = true;
            btnStop.innerText = "Memproses...";
        });
    </script>
</x-app-layout>