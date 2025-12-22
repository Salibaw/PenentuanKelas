<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function cekKelas(Request $request)
    {
        $query = $request->get('q');

        $hasil = \App\Models\HasilSpk::with(['alternatif', 'walikelas'])
            ->when($query, function ($q) use ($query) {
                $q->whereHas('alternatif', function ($sq) use ($query) {
                    $sq->where('nama_lengkap', 'like', '%' . $query . '%');
                });
            })
            ->orderBy('ranking', 'asc')
            ->get();

        return view('penentuankelas', compact('hasil'));
    }
}
