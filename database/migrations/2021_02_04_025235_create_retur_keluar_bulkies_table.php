<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturKeluarBulkiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retur_keluar_bulkies', function (Blueprint $table) {
            $table->id();
            $table->string('barang_kode');
            $table->foreign('barang_kode')->references('kode_barang')->on('barangs')->onDelete('cascade');
            $table->foreignId('pengurus_gudang_id')->constrained('pengurus_gudang_bulkies')->onDelete('cascade');
            $table->foreignId('storage_masuk_id')->constrained('storage_masuk_bulkies')->onDelete('cascade');
            $table->float('jumlah_barang', 11, 2);
            $table->string('satuan');
            $table->string('nomor_kwitansi');
            $table->date('tanggal_pengembalian');
            $table->text('keterangan');
            $table->tinyInteger('status')->nullable()->comment("1 = Diterima, 2 = Ditolak");
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
        Schema::dropIfExists('retur_keluar_bulkies');
    }
}
