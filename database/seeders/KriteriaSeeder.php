<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            ['nama_kriteria' => 'Akademik', 'bobot' => 40, 'tipe_input' => 'angka', 'jenis' => 'benefit'],
            ['nama_kriteria' => 'Zonasi', 'bobot' => 15, 'tipe_input' => 'angka', 'jenis' => 'cost'],
            ['nama_kriteria' => 'Afirmasi', 'bobot' => 15, 'tipe_input' => 'pilihan', 'jenis' => 'benefit'],
            ['nama_kriteria' => 'Prestasi', 'bobot' => 20, 'tipe_input' => 'pilihan', 'jenis' => 'benefit'],
            ['nama_kriteria' => 'Tahfidz', 'bobot' => 10, 'tipe_input' => 'pilihan', 'jenis' => 'benefit'],
        ];

        foreach ($data as $d) {
            \App\Models\Kriteria::create($d);
        }
    }
}
