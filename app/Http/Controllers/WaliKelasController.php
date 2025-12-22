<?php

namespace App\Http\Controllers;

use App\Models\WaliKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WaliKelasController extends Controller
{
    public function index()
    {
        $walikelas = WaliKelas::all();
        return view('walikelas.index', compact('walikelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'nip' => 'required|string|unique:walikelas,nip|max:20',
        ]);

        try {
            WaliKelas::create($request->all());
            return redirect()->back()->with('success', 'Data Wali Kelas berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambah data: ' . $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $walikelas = WaliKelas::find($request->id);
        return view('walikelas.edit', compact('walikelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'nip' => 'required|string|max:20|unique:walikelas,nip,' . $id,
        ]);

        try {
            $walikelas = WaliKelas::findOrFail($id);
            $walikelas->update($request->all());
            return redirect()->back()->with('success', 'Data Wali Kelas berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data.');
        }
    }

    public function delete($id)
    {
        try {
            WaliKelas::destroy($id);
            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data.');
        }
    }
}
