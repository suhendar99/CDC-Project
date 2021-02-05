<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorageBulkiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_bulkies', function (Blueprint $table) {
            $table->id();
            $table->string('storage_masuk_bulky_kode');
            $table->foreign('storage_masuk_bulky_kode')->references('kode')->on('storage_masuk_bulkies')->onDelete('cascade');
            $table->float('jumlah', 11, 2);
            $table->string('satuan');
            $table->dateTime('waktu');
            $table->foreignId('tingkat_id')->nullable()->constrained('tingkat_rak_bulkies')->onDelete('set null');
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
        Schema::dropIfExists('storage_bulkies');
    }
}
