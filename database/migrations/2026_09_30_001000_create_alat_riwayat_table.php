<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAlatRiwayatTable extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE alat MODIFY COLUMN kondisi ENUM('baik', 'rusak_ringan', 'rusak_berat', 'rusak') NOT NULL DEFAULT 'baik'");

        Schema::create('alat_riwayat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alat_id')->constrained('alat');
            $table->date('tanggal');
            $table->string('nama_pelapor');
            $table->enum('jenis', ['rusak', 'dalam_perbaikan', 'layak_pakai']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alat_riwayat');
        DB::statement("UPDATE alat SET kondisi = 'rusak_berat' WHERE kondisi = 'rusak'");
        DB::statement("ALTER TABLE alat MODIFY COLUMN kondisi ENUM('baik', 'rusak_ringan', 'rusak_berat') NOT NULL DEFAULT 'baik'");
    }
}
