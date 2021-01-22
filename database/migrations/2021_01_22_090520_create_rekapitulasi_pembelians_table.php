<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapitulasiPembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekapitulasi_pembelians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_in_id')->constrained('storage_ins')->onDelete('cascade');
            $table->date('tanggal_pembelian');
            $table->string('no_pembelian');
            $table->string('no_kwitansi')->nullable();
            $table->string('no_surat_jalan')->nullable();
            $table->string('nama_penjual');
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
        Schema::dropIfExists('rekapitulasi_pembelians');
    }
}
