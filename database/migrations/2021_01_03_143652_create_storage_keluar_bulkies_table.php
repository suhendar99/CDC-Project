<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorageKeluarBulkiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_keluar_bulkies', function (Blueprint $table) {
            $table->id();
            // $table->string('barang_kode');
            // $table->foreign('barang_kode')->references('kode_barang')->on('barangs')->onDelete('cascade');
            $table->foreignId('pemesanan_bulky_id')->constrained('pemesanan_bulkies')->onDelete('cascade');
            $table->foreignId('barang_bulky_id')->constrained('stock_barang_bulkies')->onDelete('cascade');
            // $table->foreignId('barang_kode')->nullable()->constrained('kategoris')->onDelete('cascade');
            $table->foreignId('bulky_id')->constrained('gudang_bulkies')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('kode')->unique();
            $table->float('jumlah', 11, 2);
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
        Schema::dropIfExists('storage_keluar_bulkies');
    }
}
