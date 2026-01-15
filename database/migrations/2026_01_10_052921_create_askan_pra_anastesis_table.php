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
        Schema::create('askan_anastesis', function (Blueprint $table) {
            $table->id();
            $table->string('noreg')->unique();
            $table->string('fase');
            $table->bigInteger('user_id');
            $table->text('askan_data')->nullable();
            $table->timestamps();

            $table->unique(['noreg', 'fase']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('askan_anastesis');
    }
};
