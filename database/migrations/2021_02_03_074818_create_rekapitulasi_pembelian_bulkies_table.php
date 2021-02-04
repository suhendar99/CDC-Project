<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapitulasiPembelianBulkiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekapitulasi_pembelian_bulkies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_masuk_bulky_id')->constrained('storage_masuk_bulkies')->onDelete('cascade');
            $table->dateTime('tanggal_pembelian', 0);
            $table->string('no_pembelian', 50);
            $table->string('no_kwitansi', 200)->nullable();
            $table->string('no_surat_jalan', 200)->nullable();
            $table->string('nama_penjual', 50);
            $table->string('barang', 100);
            $table->integer('jumlah');
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
        Schema::dropIfExists('rekapitulasi_pembelian_bulkies');
    }
}
