<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstTanamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_tanaman', function (Blueprint $table) {
            $table->id('id_tanaman');
            $table->unsignedBigInteger('jenis_tanam')->nullable();
            $table->unsignedBigInteger('jenis_panen')->nullable();
            $table->string('nama_tanaman',30)->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_tanaman');
    }
}
