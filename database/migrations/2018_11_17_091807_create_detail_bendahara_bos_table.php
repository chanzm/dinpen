<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailBendaharaBosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_bendahara_bos', function (Blueprint $table) {
            $table->increments('id_bendahara_bos');
            $table->unsignedInteger('unit_id');
            $table->foreign('unit_id')
            ->references('unit_id')->on('unit_kerjas')
            ->onDelete('cascade')->onUpdate('cascade');
            // $table->string('nama_bendahara_bos');
            $table->string('pangkat_bendahara_bos');
            $table->string('nip_bendahara_bos');
            $table->string('alamat_bendahara_bos');
            $table->string('sk_bendahara_bos');
            $table->date('tgl_sk_bendahara_bos');
            $table->string('telp_bendahara_bos');
            $table->date('periode_awal_bendahara_bos');
            $table->date('periode_akhir_bendahara_bos');
            // $table->date('created_at');
            // $table->string('created_by');
            $table->string('ktp_bendahara_bos');
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
        Schema::dropIfExists('detail_bendahara_bos');
    }
}
