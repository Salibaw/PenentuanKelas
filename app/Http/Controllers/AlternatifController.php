<?php

namespace App\Http\Controllers;

use App\Models\Alternatif; // Asumsi nama model Anda Alternatif
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    public function index()
    {
        $siswa = Alternatif::orderBy('nama_lengkap', 'asc')->get();
        return view('alternatif.index', compact('siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nomor_pendaftaran' => 'nullable|string|unique:alternatifs',
        ]);

        Alternatif::create($request->all());
        return redirect()->back()->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Request $request)
    {
        $siswa = Alternatif::find($request->id);
        return view('alternatif.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Alternatif::findOrFail($id);
        $siswa->update($request->all());
        return redirect()->back()->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function delete($id)
    {
        Alternatif::destroy($id);
        return redirect()->back()->with('success', 'Siswa berhasil dihapus.');
    }
}