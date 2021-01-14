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
            $table->string('nama_barang',100);
            $table->integer('jumlah');
            $table->string('satuan',10);
            $table->integer('harga');
            $table->integer('diskon')->nullable();
            $table->integer('pajak')->nullable();
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
