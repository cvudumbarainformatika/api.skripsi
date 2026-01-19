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
        Schema::create('assasement_pra_anastesis', function (Blueprint $table) {
            $table->id();
            $table->string('noreg');
            $table->string('klassifikasi_asa')->nullable();
            $table->string('keterangan_klassifikasi_asa')->nullable();
            $table->string('jenis_anastesi')->nullable();
            $table->text('teknik_anastesi')->nullable();
            $table->text('indikasi')->nullable();
            $table->string('kode_user')->nullable();
            $table->string('nama_pelaksana')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assasement_pra_anastesis');
    }
};
