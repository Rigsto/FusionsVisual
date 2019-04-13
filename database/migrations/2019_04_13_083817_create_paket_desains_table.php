<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketDesainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_desains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category');
            $table->string('tipe');
            $table->integer('harga');
            $table->integer('tambahanHarga');
            $table->integer('duration')->default(1);
            $table->integer('revisi')->default(1);
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
        Schema::dropIfExists('paket_desains');
    }
}
