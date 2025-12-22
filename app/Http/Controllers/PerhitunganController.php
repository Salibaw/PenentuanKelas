<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Penilaian;
use App\Models\HasilSpk;
use App\Models\WaliKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerhitunganController extends Controller
{
    public function index()
    {
        // Mengambil hasil SPK yang sudah diranking, beserta data siswa dan wali kelasnya
        $hasil = HasilSpk::with(['alternatif', 'walikelas'])
            ->orderBy('ranking', 'asc')
            ->get();

        return view('perangkingan.index', compact('hasil'));
    }

    public function hitung()
    {
        $kriteria = Kriteria::all();
        $siswa = Alternatif::with('penilaian')->get();
        $walikelas = WaliKelas::all();

        if ($siswa->isEmpty() || $kriteria->isEmpty()) {
            return redirect()->back()->with('error', 'Data siswa atau kriteria masih kosong!');
        }

        // 1. Normalisasi Bobot (Total harus 1)
        $totalBobot = $kriteria->sum('bobot');
        $bobotNormal = [];
        foreach ($kriteria as $k) {
            $bobotNormal[$k->id] = ($totalBobot > 0) ? ($k->bobot / $totalBobot) : 0;
        }

        // 2. Cari Min & Max per Kriteria untuk Nilai Utilitas
        $minMax = [];
        foreach ($kriteria as $k) {
            $scores = Penilaian::where('kriteria_id', $k->id)->pluck('nilai')->toArray();

            if (empty($scores)) {
                $minMax[$k->id] = ['min' => 0, 'max' => 100]; // Fallback jika data kosong
            } else {
                $minMax[$k->id] = [
                    'min' => min($scores),
                    'max' => max($scores)
                ];
            }
        }

        $hasilAkhir = [];
        foreach ($siswa as $s) {
            $totalSkor = 0;
            foreach ($kriteria as $k) {
                $nilaiMentah = $s->penilaian->where('kriteria_id', $k->id)->first()->nilai ?? 0;
                $cMin = $minMax[$k->id]['min'];
                $cMax = $minMax[$k->id]['max'];

                // 3. Hitung Nilai Utilitas (u)
                if ($cMax == $cMin) {
                    $u = 1; // Jika semua nilai sama, utilitas dianggap maksimal
                } else {
                    if ($k->jenis == 'benefit') {
                        $u = ($nilaiMentah - $cMin) / ($cMax - $cMin);
                    } else { // Cost
                        $u = ($cMax - $nilaiMentah) / ($cMax - $cMin);
                    }
                }

                // 4. Hitung Nilai Akhir (V)
                $totalSkor += ($u * $bobotNormal[$k->id]);
            }

            $hasilAkhir[] = [
                'alternatif_id' => $s->id,
                'total_skor' => $totalSkor
            ];
        }

        // 5. Sorting berdasarkan skor tertinggi (Ranking)
        usort($hasilAkhir, fn($a, $b) => $b['total_skor'] <=> $a['total_skor']);

        // 6. Simpan ke Database & Pembagian Kelas Otomatis
        DB::beginTransaction();
        try {
            HasilSpk::truncate(); // Bersihkan hasil lama

            foreach ($hasilAkhir as $index => $h) {
                $rank = $index + 1;

                // Tentukan nomor urut kelas (setiap 31 siswa ganti kelas)
                $nomorUrutKelas = ceil($rank / 31);

                // Format Nama Kelas: 7-1, 7-2, 7-3, dst.
                $namaKelas = '7-' . $nomorUrutKelas;

                // Ambil ID wali kelas berdasarkan urutan (index array mulai dari 0)
                $waliId = $walikelas[$nomorUrutKelas - 1]->id ?? null;

                HasilSpk::create([
                    'alternatif_id' => $h['alternatif_id'],
                    'total_skor'    => $h['total_skor'],
                    'ranking'       => $rank,
                    'kelas'         => $namaKelas,
                    'walikelas_id'  => $waliId
                ]);
            }

            DB::commit();
            return redirect()->route('perangkingan.index')->with('success', 'Perhitungan SMART Selesai! Kelas 7-1, 7-2, dst telah terbentuk.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan hasil: ' . $e->getMessage());
        }
    }
    public function cetak(Request $request)
    {
        $kelas = $request->get('kelas');

        $data = \App\Models\HasilSpk::with(['alternatif', 'walikelas'])
            ->when($kelas, function ($query) use ($kelas) {
                $query->where('kelas', $kelas);
            })
            ->orderBy('ranking', 'asc')
            ->get();

        return view('perangkingan.cetak', compact('data', 'kelas'));
    }
}
