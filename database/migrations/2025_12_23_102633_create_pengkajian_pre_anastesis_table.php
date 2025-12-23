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
        Schema::create('pengkajian_pre_anastesis', function (Blueprint $table) {
            $table->id();
            $table->bigIncrements('id'); // PK + index default

            // Nomor registrasi (1 kunjungan = 1 pengkajian)
            $table->string('noreg')->unique();

            // Data utama (disimpan sebagai TEXT)
            $table->text('anamnesis')->nullable();
            $table->text('pemeriksaan_fisik_umum')->nullable();
            $table->text('pemeriksaan_jalan_napas')->nullable();

            // Soft delete & audit
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengkajian_pre_anastesis');
    }
};
