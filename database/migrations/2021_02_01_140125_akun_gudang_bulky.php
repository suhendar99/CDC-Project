<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AkunGudangBulky extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akun_gudang_bulkys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bulky_id')->constrained('gudang_bulkies')->onDelete('cascade');
            $table->foreignId('pengurus_bulky_id')->constrained('pengurus_gudang_bulkies')->onDelete('cascade');
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
        Schema::dropIfExists('akun_gudangs');
    }
}
