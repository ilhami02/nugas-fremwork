<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    use HasFactory;

    // Memberitahu Laravel kolom mana saja yang boleh diisi
    protected $fillable = [
        'judul', 
        'pembicara', 
        'kategori_prodi', 
        'deskripsi', 
        'tanggal_acara', 
        'url_video', 
        'file_modul'
    ];
}