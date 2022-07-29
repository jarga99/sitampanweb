<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationTanamAndPanenToProduktivitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_produktivitas', function (Blueprint $table) {
            $table->foreign('tanam_id')->references('id_tanam')->on('mst_tanam');
            $table->foreign('panen_id')->references('id_panen')->on('mst_panen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_produktivitas', function (Blueprint $table) {
            $table->dropForeign('tb_produktivitas_tanam_id_foreign');
            $table->dropForeign('tb_produktivitas_panen_id_foreign');
            });

    }
}
