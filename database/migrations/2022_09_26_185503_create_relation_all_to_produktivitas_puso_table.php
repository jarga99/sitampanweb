<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationAllToProduktivitasPusoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_produktivitas_puso', function (Blueprint $table) {
            $table->foreign('tanaman_id')->references('id_tanaman')->on('mst_tanaman')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('kecamatan_id')->references('id_kecamatan')->on('mst_kecamatan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('desa_id')->references('id_desa')->on('mst_desa')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('created_by')->references('id_user')->on('tb_user')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_produktivitas_puso', function (Blueprint $table) {
            $table->dropForeign('tb_produktivitas_puso_tanaman_id_foreign');
            $table->dropForeign('tb_produktivitas_puso_kecamatan_id_foreign');
            $table->dropForeign('tb_produktivitas_puso_desa_id_foreign');
            $table->dropForeign('tb_produktivitas_puso_created_by_foreign');
        });
    }
}
