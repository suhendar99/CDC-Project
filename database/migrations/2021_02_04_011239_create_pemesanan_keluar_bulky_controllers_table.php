<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemesananKeluarBulkyControllersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanan_keluar_bulky', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nomor_pemesanan')->unique();
            $table->foreignId('bulky_id')->constrained('gudang_bulkies')->onDelete('cascade');
            $table->string('barang_kode');
            $table->foreign('barang_kode')->references('kode_barang')->on('barangs')->onDelete('cascade');
            $table->float('jumlah', 11, 2);
            $table->string('satuan');
            $table->string('penerima_po', 50);
            $table->string('nama_pemesan', 50);
            $table->string('telepon', 30);
            $table->text('alamat_pemesan');
            $table->text('foto_bukti')->nullable()->default(null);
            $table->dateTime('tanggal_pemesanan', 0);
            $table->string('metode_pembayaran', 50)->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('pemesanan_keluar_bulky_controllers');
    }
}
