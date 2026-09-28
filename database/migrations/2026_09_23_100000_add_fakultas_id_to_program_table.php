<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFakultasIdToProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program', function (Blueprint $table) {
            $table->foreignId('fakultas_id')
                ->nullable()
                ->after('id')
                ->constrained('fakultas')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program', function (Blueprint $table) {
            $table->dropForeign(['fakultas_id']);
            $table->dropColumn('fakultas_id');
        });
    }
}
