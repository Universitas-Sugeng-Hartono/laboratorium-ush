<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfessionalFieldsToAbsensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->string('kategori_tamu', 60)->nullable()->after('tamu');
            $table->string('identitas', 50)->nullable()->after('kategori_tamu');
            $table->string('instansi', 150)->nullable()->after('identitas');
            $table->string('kategori_keperluan', 100)->nullable()->after('jumlah_tamu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropColumn(['kategori_tamu', 'identitas', 'instansi', 'kategori_keperluan']);
        });
    }
}
