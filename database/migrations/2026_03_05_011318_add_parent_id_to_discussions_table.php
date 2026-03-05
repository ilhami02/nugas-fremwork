<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('discussions', function (Blueprint $table) {
            // Kolom ini boleh kosong (nullable). Jika kosong = komentar utama. Jika ada isinya = balasan.
            $table->foreignId('parent_id')->nullable()->constrained('discussions')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('discussions', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};
