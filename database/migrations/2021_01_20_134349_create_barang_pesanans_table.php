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
            $table->foreignId('barang_retail_id')->constrained('stock_barangs')->onDelete('cascade');
            $table->string('nama_barang',100);
            $table->float('jumlah_barang', 11, 2);
            $table->string('satuan', 50);
            $table->bigInteger('harga');
            $table->integer('ongkir')->nullable();
            $table->integer('pajak')->nullable();
            $table->integer('biaya_admin')->nullable();
            $table->foreignId('pemesanan_id')->constrained('pemesanans')->onDelete('cascade');
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
