<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabaRugiRetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laba_rugi_retails', function (Blueprint $table) {
            $table->id();
            $table->integer('bulan');
            $table->bigInteger('laba_kotor');
            $table->bigInteger('penjualan');
            $table->bigInteger('pembelian');
            $table->bigInteger('biaya_operasional');
            $table->bigInteger('laba_bersih');
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
        Schema::dropIfExists('laba_rugi_retails');
    }
}
