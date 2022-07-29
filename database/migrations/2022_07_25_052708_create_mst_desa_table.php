<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstDesaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_desa', function (Blueprint $table) {
            $table->id('id_desa')->unique();
            $table->unsignedBigInteger('kecamatan_id');
            $table->string('jenis',10);
            $table->string('nama_desa',20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_desa');
    }
}
