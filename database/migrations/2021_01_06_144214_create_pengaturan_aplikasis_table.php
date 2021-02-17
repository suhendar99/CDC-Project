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
            $table->text('logo_tab')->nullable();
            $table->text('logo_app')->nullable();
            $table->text('logo_pemasok')->nullable();
            $table->text('logo_bulky')->nullable();
            $table->text('logo_retail')->nullable();
            $table->text('logo_warung')->nullable();
            $table->text('logo_pembeli')->nullable();
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
