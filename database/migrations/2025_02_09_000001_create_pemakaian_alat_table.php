<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemakaianAlatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemakaian_alat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemakaian_id')->constrained('pemakaian')->onDelete('cascade');
            $table->foreignId('alat_id')->constrained('alat')->onDelete('cascade');
            $table->integer('jumlah_pinjam')->nullable();
            $table->integer('jumlah_kembali')->nullable();
            $table->integer('rusak')->nullable();
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
        Schema::dropIfExists('pemakaian_alat');
    }
}
