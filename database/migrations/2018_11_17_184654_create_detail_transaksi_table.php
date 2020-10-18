<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->increments('id_detail_transaksi');
            $table->unsignedInteger('id_transaksi');
            $table->string('nama_detail_tansaksi');
            $table->bigInteger('nilai');
            $table->boolean('status');
            $table->string('tujuan');
            $table->string('nama_tujuan');
            $table->foreign('id_transaksi')
            ->references('id_transaksi')->on('transaksi')
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
        Schema::dropIfExists('detail_transaksi');
    }
}
