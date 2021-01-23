<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapitulasiPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekapitulasi_penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_out_id')->constrained('storage_outs')->onDelete('cascade');
            $table->date('tanggal_penjualan');
            $table->string('no_penjualan');
            $table->string('no_kwitansi')->nullable();
            $table->string('no_surat_jalan')->nullable();
            $table->string('nama_pembeli');
            $table->string('barang');
            $table->string('jumlah');
            $table->string('satuan');
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
        Schema::dropIfExists('rekapitulasi_penjualans');
    }
}