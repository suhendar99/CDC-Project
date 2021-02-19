<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturMasukBulkiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retur_masuk_bulkies', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('kwitansi_bulky_id')->constrained('kwitansi_bulkies')->onDelete('cascade');
            $table->foreignId('pemesanan_bulky_id')->constrained('pemesanan_bulkies')->onDelete('cascade');
            $table->foreignId('barang_bulky_id')->constrained('stock_barang_bulkies')->onDelete('cascade');
            $table->string('nama_barang');
            $table->float('jumlah', 11, 4);
            $table->foreignId('satuan_id')->nullable()->constrained('satuans')->onDelete('set null');
            $table->string('bukti_kwitansi')->nullable();
            $table->string('nomor_kwitansi');
            $table->date('tanggal_pengembalian');
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('retur_masuk_bulkies');
    }
}
