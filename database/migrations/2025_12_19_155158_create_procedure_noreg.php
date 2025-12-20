<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS noreg;");
        DB::unprepared("
            CREATE DEFINER=`admin`@`%` PROCEDURE noreg(OUT nomor INT)
            BEGIN
                -- Atomic increment (anti race condition)
                UPDATE counter
                SET noreg = LAST_INSERT_ID(noreg + 1);

                -- Ambil nilai yang baru
                SELECT LAST_INSERT_ID() INTO nomor;
            END

        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS noreg;");
    }
};
