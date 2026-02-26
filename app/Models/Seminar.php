<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'pembicara',
        'kategori_prodi',
        'deskripsi',
        'tanggal_acara',
        'url_video',
        'file_modul',
        'views_count',
        'rangkuman_ai',
    ];
}