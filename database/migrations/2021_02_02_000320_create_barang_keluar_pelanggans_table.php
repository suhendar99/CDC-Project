<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangKeluarPelanggansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_keluar_pelanggans', function (Blueprint $table) {
            $table->id();
            $table->string('barang_warung_kode');
            $table->foreign('barang_warung_kode')->references('kode')->on('barang_warungs')->onDelete('cascade');
            $table->foreignId('pemesanan_id')->constrained('pemesanan_pembelis')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('kode')->unique();
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
        Schema::dropIfExists('barang_keluar_pelanggans');
    }
}
