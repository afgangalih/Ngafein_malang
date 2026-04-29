<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BobotKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bobot_kriteria')->truncate();

        DB::table('bobot_kriteria')->insert([
            [
                'nama_kriteria' => 'harga',
                'bobot' => 0.20,
                'tipe' => 'cost',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kriteria' => 'jarak',
                'bobot' => 0.20,
                'tipe' => 'cost',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kriteria' => 'fasilitas',
                'bobot' => 0.20,
                'tipe' => 'benefit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kriteria' => 'jam_operasional',
                'bobot' => 0.15,
                'tipe' => 'benefit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kriteria' => 'menu',
                'bobot' => 0.15,
                'tipe' => 'benefit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kriteria' => 'rating',
                'bobot' => 0.10,
                'tipe' => 'benefit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
