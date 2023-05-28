<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id();
            $table->uuid('trans_id')->index();
            $table->string('kategori');
            $table->string('nama');
            $table->string('jumlah');
            $table->string('harga');
            $table->string('folder');
            $table->string('gambar');
            $table->string('keterangan');
            $table->string('status')->default(0);
            $table->timestamps();

            $table->foreign('trans_id')->references('id')->on('transaksis')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_transaksis');
    }
}
