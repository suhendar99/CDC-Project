<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangPesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('barang_kode');
            $table->foreign('barang_kode')->references('kode_barang')->on('barangs')->onDelete('cascade');
            $table->integer('jumlah_barang');
            $table->string('satuan');
            $table->bigInteger('harga');
            $table->bigInteger('total_harga');
            $table->foreignId('pesanan_id')->constrained('pemesanans')->onDelete('cascade');
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
        Schema::dropIfExists('barang_pesanans');
    }
}
