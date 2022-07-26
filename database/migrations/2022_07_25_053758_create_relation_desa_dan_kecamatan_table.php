<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationDesaDanKecamatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_desa', function (Blueprint $table) {
            $table->foreign('kecamatan_id')->references('id_kecamatan')->on('mst_kecamatan')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_desa', function (Blueprint $table) {
            $table->dropForeign('mst_desa_kecamatan_id_foreign');
        });
    }
}
