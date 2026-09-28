<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailColumnsToBahanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bahan', function (Blueprint $table) {
            if (!Schema::hasColumn('bahan', 'lab_id')) {
                $table->unsignedBigInteger('lab_id')->nullable()->after('id');
                $table->foreign('lab_id')->references('id')->on('laboratorium')->onDelete('set null');
            }
            if (!Schema::hasColumn('bahan', 'satuan')) {
                $table->string('satuan')->nullable()->after('jumlah');
            }
            if (!Schema::hasColumn('bahan', 'stok_minimum')) {
                $table->integer('stok_minimum')->default(0)->after('satuan');
            }
            if (!Schema::hasColumn('bahan', 'lokasi_penyimpanan')) {
                $table->string('lokasi_penyimpanan')->nullable()->after('stok_minimum');
            }
            if (!Schema::hasColumn('bahan', 'spesifikasi')) {
                $table->text('spesifikasi')->nullable()->after('lokasi_penyimpanan');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bahan', function (Blueprint $table) {
            $table->dropForeign(['lab_id']);
            $table->dropColumn(['lab_id', 'satuan', 'stok_minimum', 'lokasi_penyimpanan', 'spesifikasi']);
        });
    }
}
