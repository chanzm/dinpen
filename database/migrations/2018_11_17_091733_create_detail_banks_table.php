<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_banks', function (Blueprint $table) {
            $table->increments('id_bank');
            $table->unsignedInteger('unit_id');
            $table->string('nama_bank');
            $table->string('alamat_bank');
            $table->string('nomor_rekening');
            $table->string('atas_nama');
            $table->string('jabatan')->nullable();
            $table->string('atas_nama_lainnya')->nullable();
            $table->string('jabatan_lainnya')->nullable();
            $table->string('cp');
            $table->string('tlp_cp');
            $table->string('cp_lain');
            $table->string('tlp_cp_lain');
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
        Schema::dropIfExists('detail_banks');
    }
}
