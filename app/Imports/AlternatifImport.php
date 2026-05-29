<?php

namespace App\Imports;

use App\Models\Alternatif;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AlternatifImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Abaikan atau lewati jika baris kosong
        if (empty($row['nama_lengkap'])) {
            return null;
        }

        return new Alternatif([
            'nama_lengkap'      => trim($row['nama_lengkap']),
            'nomor_pendaftaran' => isset($row['nomor_pendaftaran']) ? trim($row['nomor_pendaftaran']) : null,
        ]);
    }

    /**
     * Aturan Validasi untuk Baris Excel
     */
    public function rules(): array
    {
        return [
            // Memastikan data di dalam file Excel tidak boleh kosong dan tidak boleh kembar dengan database
            'nama_lengkap'      => 'required|string|max:255|unique:alternatifs,nama_lengkap',
            'nomor_pendaftaran' => 'nullable|max:255|unique:alternatifs,nomor_pendaftaran',
        ];
    }

    /**
     * Kustomisasi Pesan Eror agar tampil cantik di Toast Pojok Kanan Atas
     */
    public function customValidationMessages()
    {
        return [
            'nama_lengkap.required'      => 'Ada baris Excel yang kolom nama_lengkap-nya kosong.',
            'nama_lengkap.unique'        => 'Gagal Import: Ada nama siswa di dalam Excel yang sudah terdaftar di sistem.',
            'nomor_pendaftaran.unique'  => 'Gagal Import: Ada nomor pendaftaran di dalam Excel yang sudah digunakan siswa lain.',
        ];
    }
}
