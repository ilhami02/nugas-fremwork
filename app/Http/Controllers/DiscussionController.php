<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Seminar;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:discussions,id',
        ]);

        $seminar = \App\Models\Seminar::findOrFail($id);

        Discussion::create([
            'seminar_id' => $seminar->id,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Pesan Anda berhasil dikirim!');
    }
}