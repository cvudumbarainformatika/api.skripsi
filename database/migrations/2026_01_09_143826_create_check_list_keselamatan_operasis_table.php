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
        Schema::create('check_list_keselamatan_operasis', function (Blueprint $table) {
            $table->id();
            /**
             * RELASI PASIEN
             */
            $table->string('noreg');

            /**
             * SIGN IN (SEBELUM INDUKSI ANESTESI)
             */
            // konfirmasi: identitas, gelang pasien, prosedur, prosedur operasi
            $table->text('konfirmasi_pasien')->nullable(); // array

            $table->string('lokasi_operasi_ditandai')->nullable(); // Ya / Tidak dapat diterapkan
            $table->string('mesin_anestesi_lengkap')->nullable();
            $table->string('pulse_oxymeter_berfungsi')->nullable();

            $table->string('riwayat_alergi')->nullable(); // Tidak / Ya
            $table->string('keterangan_alergi')->nullable();

            $table->string('resiko_jalan_napas')->nullable(); // Tidak / Ya
            $table->string('ketersediaan_alat_bantuan')->nullable();

            $table->string('resiko_kehilangan_darah')->nullable(); // Tidak / Ya
            $table->string('dua_akses_iv')->nullable();
            $table->string('rencana_terapi_cairan')->nullable();

            /**
             * TIME OUT (SEBELUM INSISI KULIT)
             */
            $table->string('konfirmasi_tim')->nullable();
            $table->string('konfirmasi_pasien_prosedur_lokasi')->nullable();

            $table->string('antibiotik_profilaksis')->nullable(); // Ya / Tidak Berlaku
            $table->string('nama_antibiotik')->nullable();
            $table->string('jam_antibiotik')->nullable();
            $table->string('dosis_antibiotik')->nullable();

            /**
             * ANTISIPASI KEJADIAN KRITIS
             */
            // Dokter Bedah
            $table->text('langkah_kondisi_kritis')->nullable();
            $table->string('estimasi_lama_operasi')->nullable();
            $table->text('antisipasi_kehilangan_darah')->nullable();

            // Tim Anestesi
            $table->text('catatan_tim_anestesi')->nullable();

            // Tim Keperawatan
            $table->string('peralatan_steril')->nullable();
            $table->text('alat_perlu_perubahan_khusus')->nullable();

            $table->string('foto_penunjang')->nullable(); // Ya / Tidak / Belum

            /**
             * SIGN OUT (PASCA OPERASI)
             */

            $table->text('konfirmasi_verbal')->nullable();

            $table->text('review_masalah_utama')->nullable();

            $table->string('jenis_implan')->nullable();
            $table->string('kode_implan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_list_keselamatan_operasis');
    }
};
