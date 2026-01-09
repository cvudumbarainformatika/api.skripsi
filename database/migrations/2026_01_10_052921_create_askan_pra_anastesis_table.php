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
        Schema::create('askan_pra_anastesis', function (Blueprint $table) {
            $table->id();
            $table->string('noreg')->unique();
            $table->text('asuhan_pra_anestesi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('askan_pra_anastesis');
    }
};
