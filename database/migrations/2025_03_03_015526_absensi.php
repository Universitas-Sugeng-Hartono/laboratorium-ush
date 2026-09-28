<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Absensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->string('matakuliah')->nullable();
            $table->string('tamu')->nullable();
            $table->string('hp')->nullable();
            $table->string('jumlah_tamu')->nullable();
            $table->text('keperluan')->nullable();
            $table->date('tanggal')->nullable();
            $table->time('jam')->nullable();
            $table->time('jamselesai')->nullable();
            $table->string('ttd')->nullable();
            $table->foreignId('lab_id')->nullable()->constrained('laboratorium')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensi');
    }
}