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
            $table->string('storage_in_kode');
            $table->foreign('storage_in_kode')->references('kode')->on('storage_ins')->onDelete('cascade');
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
