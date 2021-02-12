<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangKeluarPemesananBulkiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_keluar_pemesanan_bulkies', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama_barang',100);
            $table->string('barang_kode', 100);
            $table->foreign('barang_kode')->references('kode_barang')->on('barangs')->onDelete('cascade');
            $table->float('jumlah_barang', 11, 2);
            $table->string('satuan', 50);
            $table->bigInteger('harga');
            $table->integer('pajak')->nullable();
            $table->integer('biaya_admin')->nullable();
            $table->foreignId('pemesanan_id')->constrained('pemesanan_keluar_bulky')->onDelete('cascade');
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
        Schema::dropIfExists('barang_keluar_pemesanan_bulkies');
    }
}