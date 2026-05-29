<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::all();
        $totalBobot = Kriteria::sum('bobot');
        return view('kriteria.index', compact('kriteria', 'totalBobot'));
    }

    public function store(Request $request)
    {
        // 1. Hitung total bobot yang sudah terpakai di database
        $currentTotal = Kriteria::sum('bobot');
        $maxAllowed = 100 - $currentTotal;

        // Cegah proses jika kuota bobot dari awal memang sudah habis (100%)
        if ($maxAllowed <= 0) {
            return redirect()->back()->with('error', 'Gagal menambah kriteria. Total bobot kriteria saat ini sudah mencapai batas maksimal (100%).');
        }

        // 2. Validasi dinamis menggunakan batas sisa bobot maksimal
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'bobot'         => 'required|numeric|min:1|max:' . $maxAllowed,
            'tipe_input'    => 'required|in:angka,pilihan',
            'jenis'         => 'required|in:benefit,cost',
        ], [
            // Pesan eror kustom agar informatif bagi user
            'bobot.max' => 'Gagal menambah kriteria. Total akumulasi bobot tidak boleh melebihi 100%. Sisa kuota bobot yang tersedia saat ini hanya ' . $maxAllowed . '%.',
            'bobot.min' => 'Bobot kriteria minimal bernilai 1%.',
        ]);

        Kriteria::create($request->all());
        return redirect()->back()->with('success', 'Kriteria berhasil ditambah.');
    }

    public function edit(Request $request)
    {
        $kriteria = Kriteria::find($request->id);
        return view('kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::findOrFail($id);
        
        // 1. Hitung total bobot dari kriteria LAIN (kecuali kriteria yang sedang di-update saat ini)
        $currentTotalOthers = Kriteria::where('id', '!=', $id)->sum('bobot');
        $maxAllowed = 100 - $currentTotalOthers;

        // 2. Validasi nilai bobot baru kriteria ini
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'bobot'         => 'required|numeric|min:1|max:' . $maxAllowed,
            'tipe_input'    => 'required|in:angka,pilihan',
            'jenis'         => 'required|in:benefit,cost',
        ], [
            'bobot.max' => 'Gagal memperbarui kriteria. Total akumulasi bobot tidak boleh melebihi 100%. Nilai bobot maksimal yang diperbolehkan untuk kriteria ini adalah ' . $maxAllowed . '%.',
            'bobot.min' => 'Bobot kriteria minimal bernilai 1%.',
        ]);

        $kriteria->update($request->all());
        return redirect()->back()->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function delete($id)
    {
        Kriteria::destroy($id);
        return redirect()->back()->with('success', 'Kriteria dihapus.');
    }
}