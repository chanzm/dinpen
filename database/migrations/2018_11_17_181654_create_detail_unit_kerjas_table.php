<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailUnitKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_unit_kerjas', function (Blueprint $table) {
            $table->increments('id_unit_kerja_detail');
            $table->unsignedInteger('unit_id');
            $table->string('nama_desa');
            $table->string('nama_kecamatan');
            $table->string('nama_kabupaten');
            $table->string('nama_provinsi');
            // $table->string('nama_kepala_sekolah');
            // $table->string('pangkat_kepala_sekolah');
            // $table->string('nip_kepala_sekolah');
            // $table->string('ktp_kepala_sekolah');
            // $table->string('alamat_kepala_sekolah');
            // $table->string('kecamatan_kepala_sekolah');
            $table->unsignedInteger('id_kepala_sekolah');
            $table->foreign('id_kepala_sekolah')
            ->references('id_kepala_sekolah')->on('detail_kepala_sekolahs')
            ->onDelete('cascade')->onUpdate('cascade');
            // $table->string('nama_bendahara');
            // $table->string('pangkat_bendahara');
            // $table->string('nip_bendahara');
            // $table->string('alamat_bendahara');
            $table->string('nama_ketua_komite_sekolah');
            $table->string('alamat_ketua_komite_sekolah');
            $table->unsignedInteger('id_bendahara_unit');
            $table->foreign('id_bendahara_unit')
            ->references('id_bendahara_unit')->on('detail_bendahara_units')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->string('nama_kkrs');
            $table->string('nip_kkrs');
            $table->string('nilai_bantuan');
            $table->string('jumlah_siswa');
            $table->string('lock');
            $table->bigInteger('nilai_bantuan_2');
            $table->string('lock2');
            // $table->string('nama_bendahara_bos');
            // $table->string('pangkat_bendahara_bos');
            // $table->string('nip_bendahara_bos');
            // $table->string('alamat_bendahara_bos');
            $table->unsignedInteger('id_bendahara_bos');
            $table->foreign('id_bendahara_bos')
            ->references('id_bendahara_bos')->on('detail_bendahara_bos')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->string('no_rek_bopda');
            $table->string('no_rek_bos');
            $table->string('sk_bendahara');
            $table->string('sk_bendahara_bos');
            $table->date('tgl_sk_bendahara');
            $table->date('tgl_sk_bendahara_bos');
            $table->string('nama_pengawas');
            $table->string('pangkat_pengawas');
            $table->string('nip_pengawas');
            $table->string('telp_kepsek');
            $table->string('telp_bendahara_bos');
            $table->string('telp_bendahara');
            $table->string('nama_yayasan');
            $table->string('ketua_yayasan');
            $table->string('alamat_yayasan');
            $table->string('nss');
            $table->string('npwpd_sekolah');
            $table->timestamps();
            $table->foreign('unit_id')
            ->references('unit_id')->on('unit_kerjas')
            ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_unit_kerjas');
    }
}
