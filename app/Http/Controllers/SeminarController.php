<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use Illuminate\Http\Request;

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
}