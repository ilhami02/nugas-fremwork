<x-app-layout>
    <x-slot name="header">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 mt-6">
            @include('components.alerts') {{-- Pastikan ini ada untuk pesan error/sukses --}}
        </div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Live Notulen: ') }} {{ $seminar->judul }}
        </h2>
    </x-slot>

    <div class="py-12 relative">
        <div id="loadingOverlay" class="hidden fixed inset-0 bg-gray-900 bg-opacity-80 z-50 flex flex-col items-center justify-center text-white">
            <div class="relative">
                <div class="w-24 h-24 border-4 border-purple-500 border-t-transparent rounded-full animate-spin"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-10 h-10 text-purple-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
            </div>
            <!-- <h3 class="mt-6 text-2xl font-bold">Gemini AI Sedang Bekerja</h3> -->
            <p class="mt-2 text-gray-400 animate-pulse">Menganalisis audio dan merangkum poin penting...</p>
        </div>

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-gray-100">
                <div class="p-10 text-center bg-gradient-to-b from-gray-50 to-white">
                    
                    <div id="idleState">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-700">Siap Mencatat?</h3>
                        <p class="text-gray-500 mt-1">Klik tombol di bawah untuk mulai merekam suara seminar.</p>
                    </div>

                    <div id="recordingState" class="hidden">
                        <div class="flex items-center justify-center mb-4">
                            <span class="flex h-3 w-3 mr-2">
                                <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-600"></span>
                            </span>
                            <span class="text-red-600 font-black tracking-widest uppercase text-sm">REC</span>
                        </div>
                        
                        <div id="timer" class="text-6xl font-mono font-bold text-gray-800 mb-6">00:00</div>

                        <div class="flex items-end justify-center gap-1 h-12 mb-8">
                            @foreach(range(1, 15) as $i)
                                <div class="w-1 bg-purple-500 rounded-full animate-bounce" style="animation-duration: {{ rand(500, 1500) }}ms; height: {{ rand(20, 100) }}%"></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="p-8 bg-gray-50 flex justify-center gap-6 border-t border-gray-100">
                    <button id="btnStart" class="group bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-10 rounded-2xl shadow-lg transition-all transform hover:scale-105 flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Mulai Rekaman
                    </button>

                    <button id="btnStop" class="hidden bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-10 rounded-2xl shadow-lg transition-all transform hover:scale-105 flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path></svg>
                        Stop
                    </button>
                </div>
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('seminar.show', $seminar->id) }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                    &larr; Batalkan dan Kembali
                </a>
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
        let startTime;
        let timerInterval;

        const btnStart = document.getElementById('btnStart');
        const btnStop = document.getElementById('btnStop');
        const idleState = document.getElementById('idleState');
        const recordingState = document.getElementById('recordingState');
        const timerDisplay = document.getElementById('timer');
        const loadingOverlay = document.getElementById('loadingOverlay');

        function updateTimer() {
            const now = new Date();
            const diff = new Date(now - startTime);
            const mins = String(diff.getUTCMinutes()).padStart(2, '0');
            const secs = String(diff.getUTCSeconds()).padStart(2, '0');
            timerDisplay.innerText = `${mins}:${secs}`;
        }

        btnStart.addEventListener('click', async () => {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder = new MediaRecorder(stream);
                
                audioChunks = [];
                mediaRecorder.start();
                
                // UI Switch
                idleState.classList.add('hidden');
                recordingState.classList.remove('hidden');
                btnStart.classList.add('hidden');
                btnStop.classList.remove('hidden');
                
                // Start Timer
                startTime = new Date();
                timerInterval = setInterval(updateTimer, 1000);

                mediaRecorder.addEventListener("dataavailable", event => {
                    audioChunks.push(event.data);
                });

                mediaRecorder.addEventListener("stop", () => {
                    clearInterval(timerInterval);
                    loadingOverlay.classList.remove('hidden'); // Tampilkan Loading

                    const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                    const file = new File([audioBlob], "rekaman.webm", { type: "audio/webm" });
                    
                    const container = new DataTransfer();
                    container.items.add(file);
                    document.getElementById('audioInput').files = container.files;
                    document.getElementById('uploadForm').submit();
                });

            } catch (err) {
                alert("Gagal mengakses microphone. Pastikan izin sudah diberikan.");
            }
        });

        btnStop.addEventListener('click', () => {
            mediaRecorder.stop();
            btnStop.disabled = true;
            btnStop.innerHTML = `<svg class="w-6 h-6 mr-3 animate-spin" ...>...</svg> Memproses...`;
        });
    </script>
</x-app-layout>