<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;

    // Tambahkan parent_id ke dalam fillable
    protected $fillable = ['seminar_id', 'user_id', 'parent_id', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seminar()
    {
        return $this->belongsTo(Seminar::class);
    }

    // Relasi untuk mengambil semua balasan dari komentar ini
    public function replies()
    {
        return $this->hasMany(Discussion::class, 'parent_id')->oldest(); // Balasan diurutkan dari yang terlama ke terbaru
    }

    // Relasi untuk mengetahui siapa induk dari balasan ini
    public function parent()
    {
        return $this->belongsTo(Discussion::class, 'parent_id');
    }
}