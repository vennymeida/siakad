<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahKolomMhs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mahasiswa', function (Blueprint $table){
            $table->string('jeniskelamin', 20)->after('nama')->nullable();
            $table->string('email', 50)->after('nama')->nullable();
            $table->text('alamat')->after('jeniskelamin')->nullable();
            $table->date('tanggallahir')->after('jeniskelamin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mahasiswa', function (Blueprint $table){
            $table->dropColumn('jeniskelamin');
            $table->dropColumn('email');
            $table->dropColumn('alamat');
            $table->dropColumn('tanggallahir');
        });
    }
}
