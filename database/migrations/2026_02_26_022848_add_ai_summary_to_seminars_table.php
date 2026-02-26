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
        Schema::table('seminars', function (Blueprint $table) {
            // Kolom text panjang untuk menampung hasil generate AI
            $table->longText('rangkuman_ai')->nullable()->after('deskripsi');
        });
    }
    
    public function down()
    {
        Schema::table('seminars', function (Blueprint $table) {
            $table->dropColumn('rangkuman_ai');
        });
    }
};
