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
            'nisn'         => $row['nisn'] ?? null,
            'jenis_kelamin'=> $row['jenis_kelamin'] ?? null,
        ]);
    }
}