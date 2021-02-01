<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangWarungsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_warungs', function (Blueprint $table) {
            $table->id();
            // $table->string('stok_kode');
            // $table->foreign('stok_kode')->references('kode')->on('stock_barangs')->onDelete('cascade');
            $table->foreignId('stok_id')->nullable()->constrained('stock_barangs')->onDelete('cascade');
            $table->foreignId('pelanggan_id')->nullable()->constrained('pelanggans')->onDelete('cascade');
            $table->bigInteger('jumlah');
            $table->string('satuan', 20);
            $table->dateTime('waktu');
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
        Schema::dropIfExists('barang_warungs');
    }
}
