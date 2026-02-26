<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SeminarController extends Controller
{
    // public function index()
    // {
    //     // Mengambil semua data dari database, diurutkan dari yang paling baru ditambahkan (latest)
    //     $seminars = Seminar::latest()->get();
        
    //     // Mengirim data $seminars ke file tampilan (view)
    //     return view('seminar.index', compact('seminars'));
    // }

    public function index(Request $request)
    {
        // Mulai query dasar
        $query = Seminar::query();

        // LOGIKA PENCARIAN (Keyword)
        // Jika ada input 'search' dari pengguna...
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('pembicara', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }

        // LOGIKA FILTER (Kategori Prodi)
        // Jika ada input 'kategori' dari dropdown...
        if ($request->filled('kategori')) {
            $query->where('kategori_prodi', $request->kategori);
        }

        // Eksekusi query, urutkan dari terbaru, dan ambil datanya
        $seminars = $query->latest()->get();
        
        // Kirim data ke view
        return view('seminar.index', compact('seminars'));
    }

    public function create()
    {
        return view('seminar.create');
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

        // Pindah halaman kembali ke daftar seminar dengan pesan sukses
        return redirect()->route('seminar.index')->with('success', 'Arsip seminar berhasil ditambahkan!');
    }


    // Menampilkan detail satu seminar berdasarkan ID
    public function show($id)
    {
        // findOrFail akan otomatis menampilkan halaman 404 Not Found jika ID tidak ada di database
        $seminar = Seminar::findOrFail($id);

        $seminar->increment('views_count'); // buat ini apa yah, view statisticks
        
        // Trik Ujian: Mengubah URL YouTube biasa menjadi URL Embed agar bisa diputar di web
        // Contoh: youtube.com/watch?v=12345 menjadi youtube.com/embed/12345
        if ($seminar->url_video) {
            $seminar->url_video = str_replace('watch?v=', 'embed/', $seminar->url_video);
        }

        return view('seminar.show', compact('seminar'));
    }

    public function toggleBookmark($id)
    {
        $seminar = Seminar::findOrFail($id);
        
        // Ambil user yang sedang login, panggil relasi bookmarks, lalu toggle seminar ini
        auth()->user()->bookmarks()->toggle($seminar->id);

        return back()->with('success', 'Status koleksi berhasil diperbarui!');
    }

    // Menampilkan daftar seminar yang disimpan user
    public function myBookmarks()
    {
        // 1. Ambil data user yang sedang login
        $user = auth()->user();

        // 2. Ambil seminar yang berelasi dengan user ini (lewat fungsi bookmarks di Model User)
        // Kita urutkan dari yang terakhir masuk (latest pivot)
        $seminars = $user->bookmarks()->latest('bookmarks.created_at')->get();

        // 3. Tampilkan ke view khusus
        return view('seminar.bookmarks', compact('seminars'));
    }

    // Fitur Simulasi AI Agent
    public function generateAiModulDummy($id)
    {
        $seminar = Seminar::findOrFail($id);

        // 1. Simulasi Loading (2 Detik) agar terlihat real
        sleep(2);

        // 2. Siapkan Konten Dummy (Pura-puranya hasil dari AI)
        // Tips Ujian: Isi konten ini dengan kalimat yang terdengar akademis
        $hasil_ai = "
        Ringkasan Eksekutif (AI Generated):
        
        Berdasarkan analisis rekaman seminar berjudul '{$seminar->judul}', berikut adalah poin-poin kuncinya:
        
        1. Latar Belakang Masalah:
           Pembicara menyoroti tantangan utama di industri saat ini adalah efisiensi energi dan adaptasi teknologi baru.
           
        2. Solusi yang Ditawarkan:
           Implementasi sistem terintegrasi dapat meningkatkan produktivitas hingga 40%.
           
        3. Kesimpulan:
           Mahasiswa disarankan untuk memperdalam pemahaman tentang algoritma dasar sebelum terjun ke framework modern.
           
        *Catatan: Modul ini digenerate otomatis oleh AI System PNC pada tanggal " . now()->format('d-m-Y H:i') . ".
        ";

        // 3. Simpan hasilnya ke database
        $seminar->update([
            'rangkuman_ai' => $hasil_ai
        ]);

        return back()->with('success', 'AI Agent (Simulasi) berhasil membuat modul rangkuman!');
    }

    public function liveNotulenPage($id) 
    {
        $seminar = Seminar::findOrFail($id);
        return view('seminar.live', compact('seminar'));
    }

    // Fungsi memproses audio rekaman
    public function processAudio(Request $request, $id)
    {

        // dd($request->allFiles(), $request->all());
        $seminar = Seminar::findOrFail($id);
        $apiKey = env('GEMINI_API_KEY');

        if (!$request->hasFile('audio_blob')) {
            return back()->with('error', 'Tidak ada suara yang terekam.');
        }

        $modelName = 'gemini-2.5-flash';

        try {
            // 1. Simpan audio
            // Laravel otomatis memberi nama unik hash, misal: lyAdEEp...webm
            $path = $request->file('audio_blob')->store('temp_audio');

            // 2. Ambil Jalur Absolut (Full Path) yang Benar
            // Ini SOLUSI ERROR-nya: Biarkan Laravel yang menentukan lokasi file sebenarnya di E:\...
            $realPath = Storage::path($path);

            // Cek apakah file benar-benar ada sebelum dibaca
            if (!file_exists($realPath)) {
                throw new \Exception("File audio gagal disimpan di server.");
            }

            // 3. Baca File dan Encode ke Base64
            $audioData = base64_encode(file_get_contents($realPath));

            // 4. Deteksi Mime Type Otomatis (PENTING!)
            // Browser Anda mengirim .webm, tapi kode lama memaksa .mp3. Ini bisa bikin Gemini bingung.
            // Kita deteksi otomatis apakah itu audio/webm, audio/mp3, atau audio/ogg.
            // $mimeType = mime_content_type($realPath);
            $mimeType = 'audio/webm';

            // 5. Kirim ke Gemini
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://generativelanguage.googleapis.com/v1beta/models/'.$modelName.':generateContent?key=' . $apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => "Dengarkan rekaman seminar ini. Bertindaklah sebagai notulis. Buatkan rangkuman notulen rapat yang berisi poin-poin penting pembicaraan."
                            ],
                            [
                                'inline_data' => [
                                    'mime_type' => $mimeType, // Gunakan mime type hasil deteksi (misal: audio/webm)
                                    'data' => $audioData
                                ]
                            ]
                        ]
                    ]
                ]
            ]);

            // 6. Ambil Hasil & Bersihkan File
            $responseData = $response->json();

            // Hapus file sementara agar storage laptop tidak penuh
            Storage::delete($path);

            if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                $notulen = $responseData['candidates'][0]['content']['parts'][0]['text'];
                $seminar->update(['rangkuman_ai' => $notulen]);
                return redirect()->route('seminar.show', $id)->with('success', 'Notulen berhasil dibuat!');
            } else {
                dd($responseData);
                return back()->with('error', 'Gagal memproses. Cek koneksi atau durasi rekaman.');
            }

        } catch (\Exception $e) {
            // Hapus file jika terjadi error di tengah jalan
            if (isset($path)) Storage::delete($path);
            return back()->with('error', 'Error Sistem: ' . $e->getMessage());
        }
    }
}