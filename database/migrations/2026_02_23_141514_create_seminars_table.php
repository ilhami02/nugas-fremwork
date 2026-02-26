<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seminars', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('pembicara');
            $table->string('kategori_prodi'); // Contoh: Teknik Informatika, Teknik Mesin
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_acara');
            $table->string('url_video')->nullable(); // Untuk link embed YouTube
            $table->string('file_modul')->nullable(); // Untuk lokasi file PDF/Modul
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminars');
    }
};
