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
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade');
            $table->foreignId('gudang_id')->constrained('gudangs')->onDelete('cascade');
            $table->string('penerima_po', 50);
            $table->string('nama_pemesan', 50);
            $table->string('telepon', 30);
            $table->text('alamat_pemesan');
            $table->text('foto_bukti')->nullable()->default(null);
            $table->dateTime('tanggal_pemesanan', 0);
            $table->string('metode_pembayaran', 50)->nullable();
            $table->enum('status',[0,1,2,3,4,5])->default(1);
            // 0 => Ditolak
            // 1 => Diproses
            // 2 => Pembayaran Diterima
            // 3 => Dipacking
            // 4 => Dikirim
            // 5 => Diterima Pembeli
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
