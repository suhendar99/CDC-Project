<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raks', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->foreignId('gudang_id')->constrained('gudangs')->onDelete('cascade');
            $table->string('nama');
            $table->integer('tinggi');
            $table->integer('panjang');
            $table->integer('lebar');
            $table->integer('kapasitas_berat');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('raks');
    }
}
