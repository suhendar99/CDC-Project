<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaturanAplikasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaturan_aplikasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tab', 50)->nullable();
            $table->string('nama_app', 50)->nullable();
            $table->string('logo_tab')->nullable();
            $table->string('logo_app')->nullable();
            $table->string('copyright_text', 50)->nullable();
            $table->string('copyright_link', 50)->nullable();
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
        Schema::dropIfExists('pengaturan_aplikasis');
    }
}
