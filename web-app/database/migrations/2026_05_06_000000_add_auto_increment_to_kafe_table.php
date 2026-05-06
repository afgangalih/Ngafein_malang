<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Mengubah kolom id_kafe menjadi AUTO_INCREMENT secara aman pada data yang sudah ada.
     */
    public function up(): void
    {
        // 1. Matikan pengecekan foreign key sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // 2. Lakukan perubahan kolom
        DB::statement('ALTER TABLE kafe MODIFY id_kafe BIGINT UNSIGNED AUTO_INCREMENT');

        // 3. Nyalakan kembali pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('ALTER TABLE kafe MODIFY id_kafe BIGINT UNSIGNED');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};
