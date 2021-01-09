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
            $table->string('kode_barang',20)->unique();
            $table->string('nama_barang',20);
            $table->string('harga_barang',20);
            $table->string('harga_total',20);
            $table->integer('jumlah');
            $table->string('satuan',10);
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
