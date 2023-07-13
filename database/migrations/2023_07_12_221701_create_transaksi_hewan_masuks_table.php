<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiHewanMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_hewan_masuks', function (Blueprint $table) {
            $table->id();
            $table->uuid('hewan_id')->index();
            $table->string('kode_hewan');
            $table->string('nama_hewan');
            $table->string('jumlah_hewan');
            $table->string('nominal_hewan');
            $table->timestamps();

            $table->foreign('hewan_id')->references('id')->on('hewans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_hewan_masuks');
    }
}
