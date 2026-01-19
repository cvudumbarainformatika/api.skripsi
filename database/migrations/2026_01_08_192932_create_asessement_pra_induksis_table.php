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
        Schema::create('asessement_pra_induksis', function (Blueprint $table) {
            $table->id();
            $table->string('noreg');
            $table->dateTime('tanggal')->nullable();
            $table->string('kesadaran')->nullable();
            $table->string('td')->nullable();
            $table->string('n')->nullable();
            $table->string('rr')->nullable();
            $table->string('suhu')->nullable();
            $table->string('saturasi')->nullable();
            $table->text('ekg')->nullable();
            $table->string('iv_line')->nullable();
            $table->string('infus_darah')->nullable();
            $table->string('jenis_infus_darah')->nullable();
            $table->string('mesin_anastesi')->nullable();
            $table->string('ga')->nullable();
            $table->text('ga_array')->nullable();
            $table->string('ra')->nullable();
            $table->text('ra_array')->nullable();
            $table->string('obat_anastesi')->nullable();
            $table->text('obat_anastesi_array')->nullable();
            $table->string('obat_emergensi')->nullable();
            $table->text('obat_emergensi_array')->nullable();
            $table->string('penyakit')->nullable();
            $table->string('nama_penyakit')->nullable();
            $table->string('alergi')->nullable();
            $table->string('nama_alergi')->nullable();
            $table->string('gigi_palsu')->nullable();
            $table->string('lensa_kontak')->nullable();
            $table->string('obat_sebelum')->nullable();
            $table->string('nama_obat_sebelum')->nullable();
            $table->text('catatan_lain')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asessement_pra_induksis');
    }
};
