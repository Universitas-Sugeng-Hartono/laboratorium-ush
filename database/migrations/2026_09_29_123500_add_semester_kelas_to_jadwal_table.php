<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSemesterKelasToJadwalTable extends Migration
{
    public function up()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            if (!Schema::hasColumn('jadwal', 'semester')) {
                $table->unsignedTinyInteger('semester')->nullable()->after('lab_id');
            }
            if (!Schema::hasColumn('jadwal', 'kelas')) {
                $table->char('kelas', 1)->nullable()->after('semester');
            }
        });
    }

    public function down()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            if (Schema::hasColumn('jadwal', 'kelas')) {
                $table->dropColumn('kelas');
            }
            if (Schema::hasColumn('jadwal', 'semester')) {
                $table->dropColumn('semester');
            }
        });
    }
}
