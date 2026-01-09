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
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();
            $table->string('noreg')->unique();
            $table->string('norm');
            $table->dateTime('tgl_mrs');
            $table->date('tgl_pengkajian')->nullable();
            $table->time('jam_pengkajian')->nullable();
            $table->text('diagnosa')->nullable();
            $table->text('rencana_tindakan')->nullable();
            $table->string('ruang_ranap')->nullable();
            $table->string('ruang_tindakan')->nullable(); // new
            $table->string('tindakan_operasi')->nullable(); // new
            $table->string('dokter_operator')->nullable(); // new
            $table->string('dokter_anastesi')->nullable(); // new
            $table->string('penata_anastesi')->nullable(); // new
            $table->string('kelas')->nullable();
            $table->string('cara_masuk')->nullable();
            $table->string('pintu_masuk')->nullable();
            $table->string('alergi')->nullable();
            $table->string('rs')->nullable();
            $table->string('status')->nullable();
            $table->string('alasan_hapus')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};
