<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockBarangBulkiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_barang_bulkies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bulky_id')->constrained('gudang_bulkies')->onDelete('cascade');
            $table->string('barang_kode');
            $table->foreign('barang_kode')->references('kode_barang')->on('barangs')->onDelete('cascade');
            $table->bigInteger('jumlah');
            $table->string('satuan');
            $table->bigInteger('harga_barang')->nullable();
            $table->float('diskon', 11, 2)->nullable();
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
        Schema::dropIfExists('stock_barang_bulkies');
    }
}
