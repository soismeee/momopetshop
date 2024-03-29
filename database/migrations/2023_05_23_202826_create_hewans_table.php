<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHewansTable extends Migration
{
    public function up()
    {
        Schema::create('hewans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_hewan')->unique();
            $table->uuid('kh_id')->index();
            $table->string('nama_hewan');
            $table->string('jkel');
            $table->string('tgl_lahir');
            $table->string('berat_hewan');
            $table->string('tinggi_hewan')->nullable();
            $table->string('gambar_hewan');
            $table->string('jumlah_hewan');
            $table->string('harga_hewan');
            $table->string('harga_beli');
            $table->string('keterangan_hewan');
            $table->timestamps();

            $table->foreign('kh_id')->references('id')->on('kategori_hewans')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('hewans');
    }
}
