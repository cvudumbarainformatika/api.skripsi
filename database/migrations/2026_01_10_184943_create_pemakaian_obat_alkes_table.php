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
        Schema::create('pemakaian_obat_alkes', function (Blueprint $table) {
            $table->id();
            $table->string('noreg');
            $table->json('cairan')->nullable();
            $table->json('alkes')->nullable();
            $table->json('obat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemakaian_obat_alkes');
    }
};
