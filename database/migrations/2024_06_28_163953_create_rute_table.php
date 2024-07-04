<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rute', function (Blueprint $table) {
            $table->id();
            $table->string('tujuan');
            $table->string('start');
            $table->string('end');
            $table->integer('harga');
            $table->time('jam');
            $table->unsignedBigInteger('transportasi_id');
            $table->timestamps();

            $table->foreign('transportasi_id')->references('id')->on('transportasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rutes');
    }
};
