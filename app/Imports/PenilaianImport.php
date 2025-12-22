<?php

namespace App\Imports;

use App\Models\Penilaian;
use App\Models\Kriteria;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PenilaianImport implements ToModel, WithHeadingRow
{
    protected $kriterias;

    public function __construct()
    {
        // Ambil semua kriteria untuk pencocokan header
        $this->kriterias = Kriteria::all();
    }

    public function model(array $row)
    {
        $siswa_id = $row['id_siswa'];

        foreach ($this->kriterias as $k) {
            // Ubah nama kriteria menjadi format slug (lowercase & underscore) 
            // agar sesuai dengan format heading otomatis Laravel Excel
            $key = strtolower(str_replace(' ', '_', $k->nama_kriteria));

            if (isset($row[$key])) {
                Penilaian::updateOrCreate(
                    [
                        'alternatif_id' => $siswa_id,
                        'kriteria_id'   => $k->id,
                    ],
                    [
                        'nilai' => $row[$key]
                    ]
                );
            }
        }
        
        return null; // Tidak mengembalikan model baru karena kita menggunakan updateOrCreate
    }
}