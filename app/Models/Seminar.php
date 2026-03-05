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

    public function discussions()
    {
        return $this->hasMany(Discussion::class)->latest(); // Otomatis urut dari yang terbaru
    }

    // Relasi ke tabel ratings
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // Fungsi bantuan untuk menghitung rata-rata bintang
    public function averageRating()
    {
        return round($this->ratings()->avg('score'), 1) ?? 0;
    }
}