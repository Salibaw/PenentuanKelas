<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WaliKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            ['nama_guru' => 'Drs. H. Ahmad Fauzi', 'nip' => '197001011995011001'],
            ['nama_guru' => 'Siti Nurhaliza, S.Pd', 'nip' => '198205122008022005'],
            ['nama_guru' => 'Budi Utomo, M.Pd', 'nip' => '197503202000031002'],
            ['nama_guru' => 'Laili Rahmawati, S.Ag', 'nip' => '198811102015042001'],
        ];

        foreach ($data as $d) {
            \App\Models\WaliKelas::create($d);
        }
    }
}
