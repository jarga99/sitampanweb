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
            $table->unsignedBigInteger('tanaman_id');
            $table->unsignedBigInteger('kecamatan_id');
            $table->unsignedBigInteger('desa_id');
            $table->float('tm')->nullable()->default(0);
            $table->float('tbm')->nullable()->default(0);
            $table->float('ttm')->nullable()->default(0);
            $table->float('luas_lahan')->nullable()->default(0);
            $table->float('lh_habis')->nullable()->default(0);
            $table->float('lh_blm_habis')->nullable()->default(0);
            $table->float('kadar')->nullable()->default(0);
            $table->float('produksi')->nullable()->default(0);
            $table->float('habis')->nullable()->default(0);
            $table->float('blm_habis')->nullable()->default(0);
            $table->float('provitas')->nullable()->default(0);
            $table->bigInteger('harga')->nullable()->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
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
