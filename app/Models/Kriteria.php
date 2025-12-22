<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'kriterias';
    protected $fillable = ['nama_kriteria', 'bobot', 'tipe_input', 'jenis'];

    // Menghubungkan kriteria ke banyak data penilaian
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'kriteria_id', 'id');
    }
}
