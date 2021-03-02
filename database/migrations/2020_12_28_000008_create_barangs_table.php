<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemasok_id')->nullable()->constrained('pemasoks')->onDelete('cascade');
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->onDelete('cascade');
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->string('harga_barang')->nullable();
            // $table->string('harga_total')->nullable()->comment('Harga Total Adalah Harga Beli !');
            $table->string('harga_beli')->nullable()->comment('Harga Total Adalah Harga Beli !');
            $table->text('deskripsi');
            $table->integer('jumlah')->nullable();
            $table->string('satuan');
            $table->integer('keuntungan')->nullable();
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
        Schema::dropIfExists('barangs');
    }
}
