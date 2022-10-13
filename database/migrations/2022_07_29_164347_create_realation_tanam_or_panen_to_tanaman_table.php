<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealationTanamOrPanenToTanamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_tanaman', function (Blueprint $table) {
            $table->foreign('jenis_tanam')->references('id_tanam')->on('mst_tanam')->onUpdate('cascade');
            $table->foreign('jenis_panen')->references('id_panen')->on('mst_panen')->onUpdate('cascade');
            $table->foreign('jenis_puso')->references('id_puso')->on('mst_puso')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_tanaman', function (Blueprint $table) {
            $table->dropForeign('mst_tanaman_jenis_tanam_foreign');
            $table->dropForeign('mst_tanaman_jenis_panen_foreign');
            $table->dropForeign('mst_tanaman_jenis_puso_foreign');
            });
    }
}
