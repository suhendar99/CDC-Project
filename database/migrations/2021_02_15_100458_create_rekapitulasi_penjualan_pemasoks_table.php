<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapitulasiPenjualanPemasoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekapitulasi_penjualan_pemasoks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_keluar_id')->constrained('storage_keluar_pemasoks')->onDelete('cascade');
            $table->dateTime('tanggal_penjualan');
            $table->string('no_penjualan', 50);
            $table->string('no_kwitansi', 50)->nullable();
            $table->string('no_surat_jalan', 50)->nullable();
            $table->string('nama_pembeli', 50);
            $table->string('barang', 100);
            $table->float('jumlah', 11, 2);
            $table->string('satuan', 20);
            $table->bigInteger('harga');
            $table->bigInteger('total');
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
        Schema::dropIfExists('rekapitulasi_penjualan_pemasoks');
    }
}
