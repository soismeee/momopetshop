<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kb_id')->index();
            $table->string('kategori');
            $table->string('nama_barang');
            $table->string('harga_barang');
            $table->string('stok_barang');
            $table->string('keterangan_barang');
            $table->string('gambar_barang');
            $table->timestamps();

            $table->foreign('kb_id')->references('id')->on('kategori_barangs')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangs');
    }
}
