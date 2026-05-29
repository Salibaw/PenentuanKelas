<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PenilaianExport;
use App\Imports\PenilaianImport; 

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $searchNama = $request->query('search_nama');
        $kriteria = Kriteria::all();

        // Gunakan eager loading 'penilaian' agar pembacaan relasi di Blade efisien
        $siswaQuery = Alternatif::with(['penilaian'])->orderBy('nama_lengkap', 'asc');
        
        if (!empty($searchNama)) {
            $siswaQuery->where('nama_lengkap', 'like', '%' . $searchNama . '%');
        }

        $siswa = $siswaQuery->get();

        // Memetakan penilaian ke dalam array map agar pencarian di Blade sangat cepat dan stabil
        $penilaian = Penilaian::whereIn('alternatif_id', $siswa->pluck('id'))
            ->get()
            ->groupBy('alternatif_id');

        return view('penilaian.index', compact('kriteria', 'siswa', 'penilaian', 'searchNama'));
    }
        
    public function store(Request $request)
    {
        // Validasi jika user menekan simpan namun tidak ada data input sama sekali
        if (!$request->has('nilai') || !is_array($request->nilai)) {
            return redirect()->back()->with('error', 'Tidak ada data nilai yang dikirim untuk disimpan.');
        }

        try {
            DB::beginTransaction();

            // Simpan atau update data nilai yang dikirim dari form aktif di layar
            foreach ($request->nilai as $alternatif_id => $kriterias) {
                foreach ($kriterias as $kriteria_id => $nilai) {
                    Penilaian::updateOrCreate(
                        [
                            'alternatif_id' => $alternatif_id,
                            'kriteria_id'   => $kriteria_id,
                        ],
                        [
                            // Jika kosong atau null, kita set default ke nilai 0
                            'nilai' => ($nilai !== null && $nilai !== '') ? $nilai : 0
                        ]
                    );
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Nilai alternatif yang ditampilkan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data nilai: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new PenilaianExport, 'template_penilaian_smpn2.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new PenilaianImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data nilai berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }
}