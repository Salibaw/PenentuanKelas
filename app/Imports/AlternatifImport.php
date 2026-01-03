<?php
namespace App\Imports;

use App\Models\Alternatif;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlternatifImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Alternatif([
            'nama_lengkap' => $row['nama_lengkap'],
            'nomor_pendaftaran'         => $row['nomor_pendaftaran'] ?? null,
        ]);
    }
}