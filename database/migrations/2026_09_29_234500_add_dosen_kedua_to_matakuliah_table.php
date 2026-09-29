<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDosenKeduaToMatakuliahTable extends Migration
{
    public function up()
    {
        Schema::table('matakuliah', function (Blueprint $table) {
            $table->string('dosen2')->nullable()->after('dosen');
            $table->string('nomor2')->nullable()->after('nomor');
        });
    }

    public function down()
    {
        Schema::table('matakuliah', function (Blueprint $table) {
            $table->dropColumn(['dosen2', 'nomor2']);
        });
    }
}
