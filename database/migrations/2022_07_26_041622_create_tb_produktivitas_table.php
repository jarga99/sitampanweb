<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbProduktivitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_produktivitas', function (Blueprint $table) {
            $table->id('id_produktivitas');
            $table->unsignedBigInteger('panen_id');
            $table->unsignedBigInteger('tanam_id');
            $table->unsignedBigInteger('tanaman_id');
            $table->unsignedBigInteger('desa_id');
            $table->bigInteger('kadar')->nullable()->default();
            $table->bigInteger('provitas')->nullable()->default();
            $table->bigInteger('harga')->nullable()->default();
            $table->float('luas_lahan')->nullable()->default();
            $table->unsignedBigInteger('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_produktivitas');
    }
}
