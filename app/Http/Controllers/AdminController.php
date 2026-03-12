<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Halaman Dashboard Admin
    public function dashboard()
    {
        $totalSeminar = Seminar::count();
        $totalViews = Seminar::sum('views_count');
        $seminars = Seminar::latest()->get();

        return view('admin.dashboard', compact('totalSeminar', 'totalViews', 'seminars'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pembicara' => 'required|string|max:255',
            'kategori_prodi' => 'required|string',
            'tanggal_acara' => 'required|date',
            'file_modul' => 'nullable|mimes:pdf,ppt,pptx|max:10240',
        ]);

        $path_modul = null;
        if ($request->hasFile('file_modul')) {
            $path_modul = $request->file('file_modul')->store('modul_seminar', 'public');
        }

        Seminar::create([
            'judul' => $request->judul,
            'pembicara' => $request->pembicara,
            'kategori_prodi' => $request->kategori_prodi,
            'deskripsi' => $request->deskripsi,
            'tanggal_acara' => $request->tanggal_acara,
            'url_video' => $request->url_video,
            'file_modul' => $path_modul,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Arsip seminar berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $seminar = Seminar::findOrFail($id);
        return view('admin.edit', compact('seminar')); 
    }
    
    public function update(Request $request, $id)
    {
        $seminar = Seminar::findOrFail($id);
        
        $request->validate([
            'judul' => 'required',
            'pembicara' => 'required',
            'rangkuman_ai' => 'nullable', 
        ]);
    
        $seminar->update($request->all());
    
        return redirect()->route('seminar.show', $id)->with('success', 'Konten seminar berhasil diperbarui!');
    }

    // ==========================================
    // INI BIAR GEMININYA YANG KERJA, SOALNYA DATA AUDIONYA DI UPLOAD
    // ==========================================

    // public function generateAiModulDummy($id)
    // {
    //     $seminar = Seminar::findOrFail($id);
    //     sleep(2);
        
    //     $hasil_ai = "
    //     Ringkasan Eksekutif (AI Generated):
    //     Berdasarkan analisis rekaman seminar berjudul '{$seminar->judul}', berikut adalah poin-poin kuncinya:
    //     ... (dummy text) ...
    //     *Catatan: Modul ini digenerate otomatis oleh AI System PNC pada tanggal " . now()->format('d-m-Y H:i') . ".
    //     ";

    //     $seminar->update(['rangkuman_ai' => $hasil_ai]);
    //     return back()->with('success', 'AI Agent (Simulasi) berhasil membuat modul rangkuman!');
    // }

    public function liveNotulenPage($id) 
    {
        $seminar = Seminar::findOrFail($id);
        return view('seminar.live', compact('seminar')); // Jika file live.blade.php mau dipindah, ubah jadi 'admin.live'
    }

    public function processAudio(Request $request, $id)
    {
        $seminar = Seminar::findOrFail($id);
        $apiKey = env('GEMINI_API_KEY');

        if (!$request->hasFile('audio_blob')) {
            return back()->with('error', 'Tidak ada suara yang terekam.');
        }

        $modelName = 'gemini-2.5-flash';

        try {
            $path = $request->file('audio_blob')->store('temp_audio');
            $realPath = Storage::path($path);

            if (!file_exists($realPath)) {
                throw new \Exception("File audio gagal disimpan di server.");
            }

            $audioData = base64_encode(file_get_contents($realPath));
            $mimeType = 'audio/webm';

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://generativelanguage.googleapis.com/v1beta/models/'.$modelName.':generateContent?key=' . $apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "Dengarkan rekaman seminar ini. Bertindaklah sebagai notulis. Buatkan rangkuman notulen rapat yang berisi poin-poin penting pembicaraan."],
                            ['inline_data' => ['mime_type' => $mimeType, 'data' => $audioData]]
                        ]
                    ]
                ]
            ]);

            $responseData = $response->json();
            Storage::delete($path);

            if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                $notulen = $responseData['candidates'][0]['content']['parts'][0]['text'];
                $notulen .= "\n\n---\n*Notulen ini dibuat otomatis pada " . now()->format('d M Y H:i') . " WIB*";
                $seminar->update(['rangkuman_ai' => $notulen]);
                return redirect()->route('seminar.show', $id)->with('success', 'Notulen berhasil dibuat!');
            } else {
                return back()->with('error', 'Gagal memproses. Cek koneksi atau durasi rekaman.');
            }

        } catch (\Exception $e) {
            if (isset($path)) Storage::delete($path);
            return back()->with('error', 'Error Sistem: ' . $e->getMessage());
        }
    }

    // ini backup kalo misal audio nya mau diupload saja
    public function uploadVoiceBackup(Request $request, $id)
    {
        // 1. Validasi file (Maksimal 20MB agar aman dikirim ke API langsung)
        $request->validate([
            'voice_file' => 'required|file|mimes:mp3,wav,ogg,m4a|max:20480', 
        ]);

        $seminar = Seminar::findOrFail($id);
        $file = $request->file('voice_file');

        // 2. Simpan file audio ke storage lokal (folder: storage/app/public/voice_backups)
        $path = $file->store('voice_backups', 'public');
        
        // 3. Persiapkan data untuk Gemini
        // Kita ubah file audio menjadi format Base64 agar bisa dikirim via HTTP
        $audioContent = base64_encode(file_get_contents(storage_path('app/public/' . $path)));
        $mimeType = $file->getMimeType();
        $apiKey = env('GEMINI_API_KEY');

        // 4. Kirim ke Gemini 1.5 Flash (Model yang support Audio)
        $response = Http::timeout(120)->post("https://generativelanguage.googleapis.com/v1beta/models/ggemini-2.5-flash:generateContent?key={$apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => 'Buatkan rangkuman dan notulen yang sangat rapi, profesional, dan terstruktur berdasarkan rekaman audio seminar ini.'],
                        [
                            'inlineData' => [
                                'mimeType' => $mimeType,
                                'data' => $audioContent
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        // 5. Proses Balasan dari AI
        if ($response->successful()) {
            $result = $response->json();

            // Ambil teks hasil generate AI
            $rangkuman = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Gagal memproses isi notulen.';

            // Update database
            $seminar->update([
                'rangkuman_ai' => $rangkuman
            ]);

            return back()->with('success', 'Voice backup berhasil diunggah dan Notulen AI telah digenerate!');
        }

        return back()->with('error', 'File terunggah, tapi gagal diproses oleh AI. Coba lagi nanti.');
    }
}