<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemesananPembeliItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanan_pembeli_items', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama_barang',100);
            $table->string('barang_kode');
            $table->foreign('barang_kode')->references('kode_barang')->on('barangs')->onDelete('cascade');
            $table->integer('jumlah_barang');
            $table->string('satuan', 20);
            $table->bigInteger('harga');
            $table->integer('pajak')->nullable()->delault(null);
            $table->integer('biaya_admin')->nullable()->delault(null);
            $table->foreignId('pemesanan_pembeli_id')->constrained('pemesanan_pembelis')->onDelete('cascade');
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
        Schema::dropIfExists('pemesanan_pembeli_items');
    }
}
