<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    protected $table = 'walikelas'; 
    protected $fillable = ['nama_guru', 'nip'];

    public function hasil_spk()
    {
        return $this->hasMany(HasilSpk::class, 'walikelas_id', 'id');
    }
}