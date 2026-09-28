<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailColumnsToAlatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alat', function (Blueprint $table) {
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik')->after('jumlah');
            $table->enum('status', ['tersedia', 'dipinjam', 'maintenance'])->default('tersedia')->after('kondisi');
            $table->text('spesifikasi')->nullable()->after('status');
            $table->string('lokasi_penyimpanan')->nullable()->after('spesifikasi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alat', function (Blueprint $table) {
            $table->dropColumn(['kondisi', 'status', 'spesifikasi', 'lokasi_penyimpanan']);
        });
    }
}
