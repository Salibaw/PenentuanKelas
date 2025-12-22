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
        $request->validate([
            'nama_kriteria' => 'required|string',
            'bobot' => 'required|numeric|min:1',
            'tipe_input' => 'required|in:angka,pilihan',
            'jenis' => 'required|in:benefit,cost',
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
        $kriteria->update($request->all());
        return redirect()->back()->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function delete($id)
    {
        Kriteria::destroy($id);
        return redirect()->back()->with('success', 'Kriteria dihapus.');
    }
}
