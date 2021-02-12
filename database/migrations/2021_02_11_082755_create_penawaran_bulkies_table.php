<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenawaranBulkiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penawaran_bulkies', function (Blueprint $table) {
            $table->id();
            $table->integer('kode')->unique();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->foreignId('gudang_bulky_id')->constrained('gudang_bulkies')->onDelete('cascade');
            $table->foreignId('pemasok_id')->constrained('pemasoks')->onDelete('cascade');
            $table->string('nama_barang');
            $table->string('harga_barang');
            $table->string('jumlah');
            $table->string('satuan');
            $table->tinyInteger('status')->nullable()->comment('0 = ditolak,1 = tawaran diterima, 2 = dikirim,3 = barang diterima');
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
        Schema::dropIfExists('penawaran_bulkies');
    }
}
