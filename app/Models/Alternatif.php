<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    protected $table = 'alternatifs';
    protected $fillable = ['nama_lengkap', 'nomor_pendaftaran'];

    // Relasi ke tabel penilaian (Satu siswa punya banyak nilai kriteria)
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'alternatif_id', 'id');
    }

    // Relasi ke hasil akhir SPK
    public function hasil_spk()
    {
        return $this->hasOne(HasilSpk::class, 'alternatif_id', 'id');
    }
}