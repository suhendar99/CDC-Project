<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTingkatRakBulkiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tingkat_rak_bulkies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rak_bulky_id')->constrained('rak_bulkies')->onDelete('cascade');
            $table->string('nama');
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
        Schema::dropIfExists('tingkat_rak_bulkies');
    }
}
