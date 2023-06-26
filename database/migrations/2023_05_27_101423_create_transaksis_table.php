<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->uuid('ac_id')->index(); // alamat customer
            $table->string('total_jumlah');
            $table->string('total_harga');
            $table->string('tgl_transaksi');
            $table->string('metode_bayar');
            $table->string('bukti')->nullable();
            $table->string('total_bayar')->default(0);
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
        Schema::dropIfExists('transaksis');
    }
}
