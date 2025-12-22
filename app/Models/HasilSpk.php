<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilSpk extends Model
{
    protected $table = 'hasil_spk';
    protected $fillable = ['alternatif_id', 'total_skor', 'ranking', 'kelas', 'walikelas_id'];

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class, 'alternatif_id');
    }

    public function walikelas()
    {
        return $this->belongsTo(WaliKelas::class, 'walikelas_id');
    }
}
