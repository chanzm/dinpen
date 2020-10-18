<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailBendaharaUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_bendahara_units', function (Blueprint $table) {
            $table->increments('id_bendahara_unit');
            $table->unsignedInteger('unit_id');
            $table->foreign('unit_id')
            ->references('unit_id')->on('unit_kerjas')
            ->onDelete('cascade')->onUpdate('cascade');
            // $table->string('nama_bendahara');
            $table->string('pangkat_bendahara');
            $table->string('nip_bendahara');
            $table->string('alamat_bendahara');
            $table->string('sk_bendahara');
            $table->date('tgl_sk_bendahara');
            $table->string('telp_bendahara');
            $table->date('periode_awal_bendahara');
            $table->date('periode_akhir_bendahara');
            // $table->date('created_at');
            // $table->string('created_by');
            $table->string('ktp_bendahara');
            // $table->string('user_default_password');
            // $table->string('user_password');
            $table->string('imei')->nullable();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('detail_bendahara_units');
    }
}
