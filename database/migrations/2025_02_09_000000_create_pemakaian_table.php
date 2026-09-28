<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemakaianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemakaian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('nama')->nullable();
            $table->string('nomor')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status_pengembalian')->nullable();
            $table->unsignedBigInteger('matakuliah_id')->nullable();
            $table->unsignedBigInteger('jadwal_id')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();
            $table->text('keperluan')->nullable();
            $table->date('tgl_peminjaman')->nullable();
            $table->date('tgl_pengembalian')->nullable();
            $table->text('alat_id')->nullable();
            $table->text('bahan_id')->nullable();
            $table->text('ttd')->nullable();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('matakuliah_id')->references('id')->on('matakuliah')->onDelete('set null');
            $table->foreign('jadwal_id')->references('id')->on('jadwal')->onDelete('set null');
            $table->foreign('program_id')->references('id')->on('program')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemakaian');
    }
}
