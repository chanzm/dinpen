<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailKepalaSekolahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_kepala_sekolahs', function (Blueprint $table) {
            $table->increments('id_kepala_sekolah');
            $table->unsignedInteger('unit_id');
            $table->foreign('unit_id')
            ->references('unit_id')->on('unit_kerjas')
            ->onDelete('cascade')->onUpdate('cascade');
            // $table->string('nama_kepala_sekolah');
            $table->string('pangkat_kepala_sekolah');
            $table->string('nip_kepala_sekolah');
            $table->string('alamat_kepala_sekolah');
            $table->string('ktp_kepala_sekolah');
            $table->string('kecamatan_kepala_sekolah');
            // $table->date('tgl_sk_kepala_sekolah');
            $table->string('telp_kepala_sekolah');
            $table->date('periode_awal_kepala_sekolah');
            $table->date('periode_akhir_kepala_sekolah');
            // $table->date('created_at');
            // $table->string('created_by');
            // $table->string('ktp_kepala_sekolah');
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
        Schema::dropIfExists('detail_kepala_sekolahs');
    }
}
