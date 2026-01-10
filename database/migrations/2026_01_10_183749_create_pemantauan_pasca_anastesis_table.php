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
        Schema::create('pemantauan_pasca_anastesis', function (Blueprint $table) {
            $table->id();
            $table->string('noreg')->unique();

            // waktu RR
            $table->string('tanggal')->nullable();
            $table->string('jam_masuk_rr')->nullable();
            $table->string('jam_keluar_rr')->nullable();

            // kondisi pasien
            $table->string('jalan_napas')->nullable();       // Bersih & lapang / Terpasang alat bantu
            $table->string('alat_bantu_napas')->nullable();  // masker, OPA, dll
            $table->string('pernapasan')->nullable();        // Spontan / Dibantu
            $table->string('bila_spontan')->nullable();      // Adekuat / Penyumbatan / Butuh alat
            $table->string('kesadaran')->nullable();

            // tabel pemantauan
            $table->text('pemantauan_vital')->nullable(); // array of object

            // instruksi pasca bedah
            $table->string('posisi_pasien')->nullable();
            $table->string('makan_minum')->nullable();
            $table->string('infus_transfusi')->nullable();
            $table->string('obat_obatan')->nullable();
            $table->string('pemantauan_ttv')->nullable();
            $table->string('lain_lain')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemantauan_pasca_anastesis');
    }
};
