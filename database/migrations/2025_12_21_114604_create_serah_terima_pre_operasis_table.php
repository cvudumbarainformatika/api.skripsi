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
        Schema::create('serah_terima_pre_operasis', function (Blueprint $table) {
            $table->id();
            $table->string('noreg')->unique();
            $table->string('kesadaran', 50)->nullable();
            $table->string('riwayat_penyakit', 50)->nullable();
            $table->string('riwayat_penyakit_lain', 50)->nullable();
            $table->string('jenis_alergi_obat', 50)->nullable();
            $table->string('reaksi_alergi_obat', 50)->nullable();
            $table->string('surat_persetujuan_operasi', 50)->nullable();
            $table->string('surat_persetujuan_anastesi', 50)->nullable();
            $table->string('mulai_puasa', 50)->nullable();
            $table->string('pengosongan_kandung_kemih', 50)->nullable();
            $table->string('gigi_palsu', 50)->nullable();
            $table->string('perhisan', 50)->nullable();
            $table->string('kosmetik', 50)->nullable();
            $table->string('cukur_daerah_operasi', 50)->nullable();
            $table->string('penandaan', 50)->nullable();
            $table->string('hasil_pemeriksaan')->nullable();
            $table->string('alat_kesehatan', 50)->nullable();
            $table->string('implan', 50)->nullable();
            $table->string('lainnya', 50)->nullable();
            $table->string('jenis_darah', 50)->nullable();
            $table->string('prc', 50)->nullable();
            $table->string('wb', 50)->nullable();
            $table->string('trombosit', 50)->nullable();
            $table->string('plasma', 50)->nullable();
            $table->string('jumlah', 50)->nullable();
            $table->string('vital_td', 50)->nullable();
            $table->string('vital_n', 50)->nullable();
            $table->string('vital_s', 50)->nullable();
            $table->string('vital_rr', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serah_terima_pre_operasis');
    }
};
