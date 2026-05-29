<?php

namespace App\Http\Controllers;

use App\Models\WaliKelas;
use Illuminate\Http\Request;

class WaliKelasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        // Mengambil data dan menambahkan filter berdasarkan Nama, NIP, atau Kelas
        $walikelas = WaliKelas::orderBy('kelas', 'asc')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nama_guru', 'like', '%' . $search . '%')
                      ->orWhere('nip', 'like', '%' . $search . '%')
                      ->orWhere('kelas', 'like', '%' . $search . '%');
                });
            })
            ->get();

        return view('walikelas.index', compact('walikelas', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'nip'       => 'required|string|max:20|unique:walikelas,nip',
            'kelas'     => 'required|string|max:50|unique:walikelas,kelas', // Validasi unik untuk kelas baru
        ], [
            'nip.unique'   => 'Gagal Menyimpan: NIP ' . $request->nip . ' sudah terdaftar pada wali kelas lain.',
            'kelas.unique' => 'Gagal Menyimpan: Kelas ' . $request->kelas . ' sudah memiliki Wali Kelas.',
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
            'nip'       => 'required|string|max:20|unique:walikelas,nip,' . $id,
            'kelas'     => 'required|string|max:50|unique:walikelas,kelas,' . $id, // Validasi unik update kelas dengan ignore ID saat ini
        ], [
            'nip.unique'   => 'Gagal Memperbarui: NIP ' . $request->nip . ' sudah digunakan oleh wali kelas lain.',
            'kelas.unique' => 'Gagal Memperbarui: Kelas ' . $request->kelas . ' sudah memiliki Wali Kelas.',
        ]);

        try {
            $walikelas = WaliKelas::findOrFail($id);
            $walikelas->update($request->all());
            return redirect()->route('walikelas.index')->with('success', 'Data Wali Kelas berhasil diperbarui.');
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