<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemakaian_bahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemakaian_id')->constrained('pemakaian')->onDelete('cascade');
            $table->foreignId('bahan_id')->constrained('bahan')->onDelete('cascade');
            $table->integer('jumlah_pakai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemakaian_bahan');
    }
};