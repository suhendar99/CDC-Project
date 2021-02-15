<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gudang_id')->constrained('gudangs')->onDelete('cascade');
            $table->foreignId('barang_bulky_id')->nullable()->constrained('stock_barang_bulkies')->onDelete('cascade');
            $table->string('nama_barang', 50);
            $table->text('foto_barang')->nullable();
            $table->float('jumlah', 11, 2);
            $table->string('satuan', 50);
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
        Schema::dropIfExists('stock_barangs');
    }
}
