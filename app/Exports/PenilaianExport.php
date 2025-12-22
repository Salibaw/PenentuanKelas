<?php
namespace App\Exports;

use App\Models\Alternatif;
use App\Models\Kriteria;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PenilaianExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Mengambil data siswa (Hanya ID dan Nama)
        return Alternatif::select('id', 'nama_lengkap')->get();
    }

    public function headings(): array
    {
        // Header tetap
        $header = ['ID_SISWA', 'NAMA_SISWA'];
        
        // Tambahkan Nama Kriteria sebagai Header Kolom
        $kriteria = Kriteria::pluck('nama_kriteria')->toArray();
        
        return array_merge($header, $kriteria);
    }
}