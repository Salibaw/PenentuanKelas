<?php

namespace App\Http\Controllers;

use App\Models\Alternatif; // Siswa
use App\Models\Kriteria;
use App\Models\WaliKelas;
use App\Models\HasilSpk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Alternatif::count();

        $data = [
            'total_siswa'    => $totalSiswa,
            'total_kriteria' => Kriteria::count(),
            'total_guru'     => WaliKelas::count(),
            'sudah_hitung'   => HasilSpk::count(),
            'top_5'          => HasilSpk::with('alternatif')->orderBy('ranking', 'asc')->take(5)->get(),

            // Tambahkan map untuk menghitung persen di sini
            'distribusi_kelas' => HasilSpk::selectRaw('kelas, count(*) as total')
                ->groupBy('kelas')
                ->get()
                ->map(function ($item) use ($totalSiswa) {
                    // Jika siswa > 0 hitung persen, jika tidak set 0
                    $item->persen = $totalSiswa > 0 ? ($item->total / $totalSiswa) * 100 : 0;
                    return $item;
                })
        ];

        return view('dashboard', compact('data'));
    }
}
