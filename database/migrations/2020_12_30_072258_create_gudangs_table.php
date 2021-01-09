<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGudangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gudangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('kontak');
            $table->string('pemilik');
            $table->integer('kapasitas');
            $table->time('jam_buka');
            $table->time('jam_tutup');
            $table->string('hari');
            $table->string('foto')->nullable();
            $table->text('alamat');
            $table->foreignId('desa_id')->nullable()->constrained('desas')->onDelete('set null');
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
        Schema::dropIfExists('gudangs');
    }
}
