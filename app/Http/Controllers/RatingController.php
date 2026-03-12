<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'score' => 'required|integer|min:1|max:5',
        ]);

        Rating::updateOrCreate(
            ['seminar_id' => $id, 'user_id' => auth()->id()],
            ['score' => $request->score]
        );

        return back()->with('success', 'Terima kasih! Penilaian Anda berhasil disimpan.');
    }
}