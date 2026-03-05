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
        return view('seminar.create'); // Jika file create.blade.php mau dipindah ke admin, ubah jadi 'admin.create'
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

    // SESUAI PERMINTAAN: View diarahkan ke folder admin
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
    // AREA AI AGENT GEMINI (TIDAK DIUTAK-ATIK)
    // ==========================================

    public function generateAiModulDummy($id)
    {
        $seminar = Seminar::findOrFail($id);
        sleep(2);
        
        $hasil_ai = "
        Ringkasan Eksekutif (AI Generated):
        Berdasarkan analisis rekaman seminar berjudul '{$seminar->judul}', berikut adalah poin-poin kuncinya:
        ... (dummy text) ...
        *Catatan: Modul ini digenerate otomatis oleh AI System PNC pada tanggal " . now()->format('d-m-Y H:i') . ".
        ";

        $seminar->update(['rangkuman_ai' => $hasil_ai]);
        return back()->with('success', 'AI Agent (Simulasi) berhasil membuat modul rangkuman!');
    }

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
}