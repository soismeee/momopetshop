<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_treatments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->string('ac_id'); // alamat customer
            $table->string('nama_treatment');
            $table->string('harga_treatment');
            $table->string('metode_bayar')->nullable();
            $table->string('gambar_treatment');
            $table->string('keterangan_treatment');
            $table->string('tgl_transaksi');
            $table->string('total_bayar')->default(0);
            $table->string('bukti')->nullable();
            $table->string('status')->default(0);
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
        Schema::dropIfExists('transaksi_treatments');
    }
}
