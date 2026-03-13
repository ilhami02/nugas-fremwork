<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar semua user
    public function index()
    {
        // Mengambil semua user, diurutkan dari yang terbaru mendaftar
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    // Menampilkan form edit user (misal: untuk ubah role)
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Memproses update data user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            // Validasi email unik, TAPI abaikan jika emailnya milik user ini sendiri
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'is_admin' => 'required|boolean',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->is_admin,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        
        // Update password menjadi kata "password" (di-hash agar aman di database)
        $user->update([
            'password' => Hash::make('password'),
        ]);

        return back()->with('success', 'Password user ' . $user->name . ' berhasil direset menjadi: password');
    }

    // Menghapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Proteksi: Mencegah admin menghapus akunnya sendiri yang sedang dipakai login
        if (auth()->id() == $user->id) {
            return back()->with('error', 'Akses Ditolak: Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus dari sistem!');
    }
}