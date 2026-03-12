<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use Illuminate\Http\Request;

class SeminarController extends Controller
{
    // Menampilkan daftar seminar dengan fitur pencarian dan filter
    public function index(Request $request)
    {
        $query = Seminar::query();

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('pembicara', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_prodi', $request->kategori);
        }

        $seminars = $query->latest()->get();
        return view('seminar.index', compact('seminars'));
    }

    // Menampilkan detail satu seminar berdasarkan ID
    public function show($id)
    {
        $seminar = Seminar::findOrFail($id);
        $seminar->increment('views_count'); 
        
        if ($seminar->url_video) {
            $seminar->url_video = str_replace('watch?v=', 'embed/', $seminar->url_video);
        }

        return view('seminar.show', compact('seminar'));
    }

    // Fitur Bookmark biar kalo butuh tinggal ke sini aja
    public function toggleBookmark($id)
    {
        $seminar = Seminar::findOrFail($id);
        auth()->user()->bookmarks()->toggle($seminar->id);
        return back()->with('success', 'Status koleksi berhasil diperbarui!');
    }

    // kalo udah di bookmark nanti disimpan disini
    public function myBookmarks()
    {
        $user = auth()->user();
        $seminars = $user->bookmarks()->latest('bookmarks.created_at')->get();
        return view('seminar.bookmarks', compact('seminars'));
    }
}