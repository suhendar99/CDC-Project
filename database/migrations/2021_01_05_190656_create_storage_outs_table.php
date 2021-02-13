<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorageOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_outs', function (Blueprint $table) {
            $table->id();
            $table->dateTime('waktu');
            $table->string('kode')->unique();
            $table->foreignId('pemesanan_id')->constrained('pemesanans')->onDelete('cascade');
            $table->foreignId('barang_retail_id')->constrained('stock_barangs')->onDelete('cascade');
            $table->foreignId('gudang_id')->constrained('gudangs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('satuan_id')->constrained('satuans')->onDelete('cascade');
            $table->bigInteger('jumlah');
            $table->timestamps();
            // $table->string('barang_kode');
            // $table->foreign('barang_kode')->references('kode_barang')->on('barangs')->onDelete('cascade');
            // $table->foreignId('barang_kode')->nullable()->constrained('kategoris')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storage_outs');
    }
}
