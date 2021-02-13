<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangPemesananBulkiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_pemesanan_bulkies', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama_barang',100);
            // $table->string('barang_kode', 100);
            // $table->foreign('barang_kode')->references('kode_barang')->on('barangs')->onDelete('cascade');
            $table->foreignId('barang_bulky_id')->constrained('stock_barang_bulkies')->onDelete('cascade');
            $table->integer('jumlah_barang');
            $table->string('satuan', 50);
            $table->bigInteger('harga');
            $table->integer('pajak');
            $table->integer('biaya_admin');
            $table->foreignId('pemesanan_bulky_id')->constrained('pemesanan_bulkies')->onDelete('cascade');
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
        Schema::dropIfExists('barang_pemesanan_bulkies');
    }
}
