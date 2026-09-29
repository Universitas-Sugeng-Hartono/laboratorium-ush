<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTanggalKedaluwarsaToBahanTable extends Migration
{
    public function up()
    {
        Schema::table('bahan', function (Blueprint $table) {
            $table->date('tanggal_kedaluwarsa')->nullable()->after('stok_minimum');
        });
    }

    public function down()
    {
        Schema::table('bahan', function (Blueprint $table) {
            $table->dropColumn('tanggal_kedaluwarsa');
        });
    }
}
