<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiPemasoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_pemasoks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemasok_id')->nullable()->constrained('pemasoks')->onDelete('cascade');
            $table->foreignId('gudang_id')->nullable()->constrained('gudangs')->onDelete('cascade');
            $table->foreignId('barang_id')->nullable()->constrained('barangs')->onDelete('cascade');
            $table->string('kode_transaksi',20)->unique();
            $table->integer('jumlah');
            $table->string('satuan',20);
            $table->enum('status',[0,1,2,3]);
            // 0 Menunggu Diapprove
            // 1 Menunggu Pengiriman dari Pemasok
            // 2 Sedang Dikirim
            // 3 Sudah Diterima
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
        Schema::dropIfExists('transaksi_pemasoks');
    }
}
