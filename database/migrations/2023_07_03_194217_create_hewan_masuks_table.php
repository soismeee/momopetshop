<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHewanMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hewan_masuks', function (Blueprint $table) {
            $table->id();
            $table->uuid('hewan_id')->index();
            $table->string('jumlah');
            $table->string('harga');
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
        Schema::dropIfExists('hewan_masuks');
    }
}
