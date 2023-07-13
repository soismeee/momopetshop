<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiBarangMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_barang_masuks', function (Blueprint $table) {
            $table->id();
            $table->uuid('barang_id')->index();
            $table->string('kode_barang');
            $table->string('kategori');
            $table->string('nama_barang');
            $table->string('jumlah_barang');
            $table->string('nominal_barang');
            $table->timestamps();

            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_barang_masuks');
    }
}
