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
        Schema::create('serah_terima_pasca_operasis', function (Blueprint $table) {
            $table->id();
            $table->string('noreg')->unique();
            $table->string('tujuan')->unique();

            // SBAR
            $table->text('situation')->nullable();
            $table->text('background')->nullable();
            $table->text('assessment')->nullable();
            $table->text('recommendation')->nullable();

            // TTD (nama saja)
            $table->string('penyerah_nama')->nullable();
            $table->string('penerima_nama')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serah_terima_pasca_opeasis');
    }
};
