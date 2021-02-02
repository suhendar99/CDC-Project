<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturMasukPelanggansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retur_masuk_pelanggans', function (Blueprint $table) {
            $table->id();
            $table->string('barang_warung_kode');
            $table->foreign('barang_warung_kode')->references('kode')->on('barang_warungs')->onDelete('cascade');
            $table->foreignId('pemesanan_pembeli_id')->constrained('pemesanan_pembelis')->onDelete('cascade');
            $table->date('tanggal_pengembalian');
            $table->text('keterangan');
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
        Schema::dropIfExists('retur_masuk_pelanggans');
    }
}
