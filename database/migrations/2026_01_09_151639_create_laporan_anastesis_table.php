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
        Schema::create('laporan_anastesis', function (Blueprint $table) {
            $table->id();

            /**
             * RELASI PASIEN
             */
            $table->string('noreg');

            /**
             * INFUS
             */
            $table->text('infus_tempat_ukuran')->nullable(); // array

            /**
             * POSISI PASIEN
             */
            $table->text('posisi_pasien')->nullable(); // array

            /**
             * PREMEDIKASI
             */
            $table->text('premedikasi')->nullable(); // array

            /**
             * INDUKSI
             */
            $table->text('induksi')->nullable(); // array

            /**
             * KLASIFIKASI ASA
             */
            $table->string('klasifikasi_asa')->nullable();

            /**
             * TATA LAKSANA JALAN NAPAS
             */
            $table->text('tata_laksana_jalan_napas')->nullable(); // array

            /**
             * INTUBASI
             */
            $table->text('intubasi')->nullable(); // array

            /**
             * VENTILASI
             */
            $table->text('ventilasi')->nullable(); // array

            /**
             * REGIONAL ANESTESI
             */
            $table->text('regional_anestesi')->nullable(); // array

            /**
             * WAKTU & DURASI
             */
            $table->string('komplikasi_anestesi')->nullable();
            $table->string('tanggal_anestesi')->nullable();
            $table->string('jam_mulai')->nullable();
            $table->string('jam_selesai')->nullable();
            $table->string('lama_anestesi')->nullable();
            $table->string('lama_operasi')->nullable();

            /**
             * MONITORING ANESTESI
             */
            $table->text('monitoring_anestesi')->nullable(); // array of object

            /**
             * REKAP AKHIR
             */
            $table->string('jumlah_cairan')->nullable();
            $table->string('jumlah_perdarahan')->nullable();
            $table->string('urin')->nullable();

            $table->dateTime('tanggal_mulai')->nullable();
            $table->dateTime('tanggal_selesai')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_anastesis');
    }
};
