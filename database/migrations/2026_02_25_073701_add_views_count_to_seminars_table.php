<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('seminars', function (Blueprint $table) {
            // Menambahkan kolom integer dengan default 0
            $table->integer('views_count')->default(0)->after('deskripsi');
        });
    }

    public function down()
    {
        Schema::table('seminars', function (Blueprint $table) {
            $table->dropColumn('views_count');
        });
    }
};
