<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('po_id')->nullable()->constrained('pos')->onDelete('cascade');
            $table->string('kode')->unique();
            $table->string('nama_barang',100);
            $table->string('barang_kode')->nullable();
            $table->foreign('barang_kode')->references('kode_barang')->on('barangs')->onDelete('cascade');
            $table->integer('jumlah_barang');
            $table->string('satuan');
            $table->integer('pajak');
            $table->integer('biaya_admin');
            $table->bigInteger('harga');
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
        Schema::dropIfExists('po_items');
    }
}
