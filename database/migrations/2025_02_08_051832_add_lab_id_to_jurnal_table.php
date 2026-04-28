<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLabIdToJurnalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jurnal', function (Blueprint $table) {
            $table->unsignedBigInteger('lab_id')->nullable()->after('id');
            $table->foreign('lab_id')->references('id')->on('laboratorium')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jurnal', function (Blueprint $table) {
            $table->dropForeign(['lab_id']);
            $table->dropColumn('lab_id');
        });
    }
}