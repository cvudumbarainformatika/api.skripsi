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
        Schema::create('laboratoria', function (Blueprint $table) {
            $table->id();
            $table->string('noreg')->unique();
            $table->string('imuno_serologi')->nullable();
            $table->string('hbsag')->nullable();
            $table->string('hemostatika')->nullable();
            $table->string('pt')->nullable();
            $table->string('appt')->nullable();
            $table->string('hematologi')->nullable();
            $table->string('monosit')->nullable();
            $table->string('eosinofil')->nullable();
            $table->string('limfosit')->nullable();
            $table->string('basofil')->nullable();
            $table->string('trombosit')->nullable();
            $table->string('eritrosit')->nullable();
            $table->string('hemoglobin')->nullable();
            $table->string('hematokrit')->nullable();

            // dll sesuai hasil pemeriksaan
            $table->text('lainnya')->nullable();

            $table->string('path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laboratoria');
    }
};
