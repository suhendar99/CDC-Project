<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storage_masuk_id')->constrained('storage_ins')->onDelete('cascade');
            $table->foreignId('barang_retail_id')->nullable()->constrained('stock_barangs')->onDelete('cascade');
            $table->float('jumlah', 11, 2);
            $table->string('satuan', 50);
            $table->dateTime('waktu');
            $table->foreignId('tingkat_id')->nullable()->constrained('tingkatan_raks')->onDelete('set null');
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
        Schema::dropIfExists('storages');
    }
}
