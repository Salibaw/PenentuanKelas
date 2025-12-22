<?php

namespace App\Http\Controllers;

use App\Models\Alternatif; // Asumsi nama model Anda Alternatif
use Illuminate\Http\Request;
use App\Imports\AlternatifImport;
use Maatwebsite\Excel\Facades\Excel;

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


    public function downloadTemplate()
    {
        // Membuat file Excel sederhana untuk contoh format
        $header = [['nama_lengkap', 'nisn', 'jenis_kelamin']];
        return Excel::download(new class($header) implements \Maatwebsite\Excel\Concerns\FromCollection {
            protected $data;
            public function __construct($data)
            {
                $this->data = $data;
            }
            public function collection()
            {
                return collect($this->data);
            }
        }, 'template_siswa.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx']);
        Excel::import(new AlternatifImport, $request->file('file'));
        return redirect()->back()->with('success', 'Data siswa berhasil diimport!');
    }
}
