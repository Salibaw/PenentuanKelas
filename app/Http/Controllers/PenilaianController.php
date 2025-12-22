<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PenilaianExport;
use App\Imports\PenilaianImport; 

class PenilaianController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::all();
        $siswa = Alternatif::orderBy('nama_lengkap', 'asc')->get();

        // Mengambil semua data penilaian untuk ditampilkan di tabel
        $penilaian = Penilaian::all()->groupBy('alternatif_id');

        return view('penilaian.index', compact('kriteria', 'siswa', 'penilaian'));
    }

    public function store(Request $request)
    {
        // Data dikirim dalam bentuk array: nilai[alternatif_id][kriteria_id]
        foreach ($request->nilai as $alternatif_id => $kriterias) {
            foreach ($kriterias as $kriteria_id => $nilai) {
                Penilaian::updateOrCreate(
                    [
                        'alternatif_id' => $alternatif_id,
                        'kriteria_id' => $kriteria_id,
                    ],
                    [
                        'nilai' => $nilai ?? 0
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Semua nilai berhasil disimpan.');
    }



    public function export()
    {
        return Excel::download(new PenilaianExport, 'template_penilaian_smpn2.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx']);

        try {
            Excel::import(new PenilaianImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data nilai berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }
}
