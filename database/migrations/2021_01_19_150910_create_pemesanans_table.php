<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nomor_pemesanan')->unique();
            $table->foreignId('pelanggan_id')->nullable()->constrained('pelanggans')->onDelete('cascade');
            $table->foreignId('pengurus_gudang_id')->nullable()->constrained('pengurus_gudangs')->onDelete('cascade');
            $table->string('penerima_po');
            $table->string('nama_pemesan');
            $table->string('telepon');
            $table->string('alamat_pemesan');
            $table->dateTime('tanggal_pemesanan', 0);
            $table->string('metode_pembayaran')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('pemesanans');
    }
}
