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
    public function index(Request $request)
    {
        // 1. Ambil input kata kunci pencarian nama
        $searchNama = $request->query('search_nama');

        // 2. Query hasil SPK dengan Eager Loading
        $hasilQuery = HasilSpk::with(['alternatif', 'walikelas'])->orderBy('ranking', 'asc');

        // 3. Filter berdasarkan nama siswa jika input pencarian diisi
        if (!empty($searchNama)) {
            $hasilQuery->whereHas('alternatif', function ($q) use ($searchNama) {
                $q->where('nama_lengkap', 'like', '%' . $searchNama . '%');
            });
        }

        $hasil = $hasilQuery->get();

        return view('perangkingan.index', compact('hasil', 'searchNama'));
    }

    public function hitung()
    {
        $kriteria = Kriteria::all();
        $siswa = Alternatif::with('penilaian')->get();

        // Ambil data wali kelas (diurutkan berdasarkan kelas binaannya agar konsisten)
        $walikelas = WaliKelas::orderBy('kelas', 'asc')->get();

        if ($siswa->isEmpty()) {
            return redirect()->back()->with('error', 'Gagal: Data pendaftaran siswa (alternatif) masih kosong!');
        }
        if ($kriteria->isEmpty()) {
            return redirect()->back()->with('error', 'Gagal: Data kriteria penilaian masih kosong!');
        }

        $totalWali = $walikelas->count();
        if ($totalWali <= 0) {
            return redirect()->back()->with('error', 'Gagal: Data Wali Kelas di database masih kosong! Harap daftarkan wali kelas terlebih dahulu di menu Wali Kelas.');
        }

        // 1. Normalisasi Bobot Kriteria (Total harus 1)
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
                $minMax[$k->id] = ['min' => 0, 'max' => 100];
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
                    $u = 1;
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

        // Menghitung pembagian rata kuota kelas secara dinamis
        $totalSiswa = count($hasilAkhir);
        $siswaPerKelas = ceil($totalSiswa / $totalWali);

        // 6. Simpan ke Database & Pembagian Kelas Otomatis
        DB::beginTransaction();
        try {
            // PERBAIKAN UTAMA: Menggunakan delete() murni, bukan truncate() agar tidak merusak Transaction
            HasilSpk::query()->delete();

            foreach ($hasilAkhir as $index => $h) {
                $rank = $index + 1;

                // Tentukan nomor urut kelas secara dinamis berdasarkan kapasitas hitung
                $nomorUrutKelas = ceil($rank / $siswaPerKelas);

                // Antisipasi jika pembulatan indeks terakhir melebihi jumlah wali kelas
                if ($nomorUrutKelas > $totalWali) {
                    $nomorUrutKelas = $totalWali;
                }

                $namaKelas = '7-' . $nomorUrutKelas;

                // Cari wali kelas yang memegang kelas ini
                $wali = $walikelas->firstWhere('kelas', $namaKelas);
                $waliId = $wali ? $wali->id : ($walikelas[$nomorUrutKelas - 1]->id ?? null);

                HasilSpk::create([
                    'alternatif_id' => $h['alternatif_id'],
                    'total_skor'    => $h['total_skor'],
                    'ranking'       => $rank,
                    'kelas'         => $namaKelas,
                    'walikelas_id'  => $waliId
                ]);
            }

            DB::commit();
            return redirect()->route('perangkingan.index')->with('success', 'Perhitungan SMART Selesai! Pembagian kelas ' . $siswaPerKelas . ' siswa/kelas berhasil dibentuk.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan hasil perhitungan: ' . $e->getMessage());
        }
    }

    public function cetak(Request $request)
    {
        $kelas = $request->get('kelas');

        $data = HasilSpk::with(['alternatif', 'walikelas'])
            ->when($kelas, function ($query) use ($kelas) {
                $query->where('kelas', $kelas);
            })
            ->orderBy('ranking', 'asc')
            ->get();

        return view('perangkingan.cetak', compact('data', 'kelas'));
    }
}
