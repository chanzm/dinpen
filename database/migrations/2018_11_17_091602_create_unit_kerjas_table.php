<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_kerjas', function (Blueprint $table) {
            $table->increments('unit_id');
            $table->string('kelompok_id');
            $table->string('unit_name');
            $table->string('unit_address');
            // $table->string('kelpala_nama')->nullable();
            // $table->string('kepala_pangkat');
            // $table->string('kepala_nip');
            $table->string('kode_permen')->nullable();
            $table->string('singkatan')->nullable();
            $table->string('tapd')->nullable();
            $table->string('dpalock')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('tipe')->nullable();
            $table->string('nss')->nullable();
            $table->string('kode_lokasi_simbada')->nullable();
            $table->string('status_merger')->nullable();
            $table->string('merger_ke')->nullable();
            $table->string('status')->nullable();
            $table->string('jenis')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_kerjas');
    }
}
