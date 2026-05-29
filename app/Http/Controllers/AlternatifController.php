<?php

namespace App\Http\Controllers;

use App\Models\Alternatif; 
use Illuminate\Http\Request;
use App\Imports\AlternatifImport;
use Maatwebsite\Excel\Facades\Excel;

class AlternatifController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil kata kunci dari input 'search'
        $search = $request->query('search');

        $siswa = Alternatif::orderBy('nama_lengkap', 'asc')
            ->when($search, function ($query, $search) {
                // PERBAIKAN: Menggunakan fungsi closure agar orWhere terbungkus di dalam kurung (Query Grouping)
                return $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', '%' . $search . '%')
                      ->orWhere('nomor_pendaftaran', 'like', '%' . $search . '%');
                });
            })
            ->paginate(10)
            ->withQueryString(); 

        return view('alternatif.index', compact('siswa'));
    }

    public function store(Request $request)
    {
        // PERBAIKAN: Menambahkan 'unique:alternatifs,nama_lengkap' agar tidak bisa input nama yang sama
        $request->validate([
            'nama_lengkap' => 'required|string|max:255|unique:alternatifs,nama_lengkap',
            'nomor_pendaftaran' => 'nullable|string|max:255|unique:alternatifs,nomor_pendaftaran',
        ], [
            // Kustomisasi pesan error (Opsional agar user paham)
            'nama_lengkap.unique' => 'Nama siswa tersebut sudah terdaftar di sistem.',
            'nomor_pendaftaran.unique' => 'Nomor pendaftaran sudah digunakan oleh siswa lain.',
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
        
        // PERBAIKAN: Menambahkan 'unique' pada nama_lengkap dengan mengabaikan ID siswa itu sendiri (ignore id)
        // Jika tidak di-ignore, saat update data tanpa mengubah nama, Laravel akan menganggapnya duplikat.
        $request->validate([
            'nama_lengkap' => 'required|string|max:255|unique:alternatifs,nama_lengkap,' . $siswa->id,
            'nomor_pendaftaran' => 'nullable|string|max:255|unique:alternatifs,nomor_pendaftaran,' . $siswa->id,
        ], [
            'nama_lengkap.unique' => 'Nama siswa tersebut sudah terdaftar di sistem.',
            'nomor_pendaftaran.unique' => 'Nomor pendaftaran sudah digunakan oleh siswa lain.',
        ]);

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
        $header = [['nama_lengkap', 'nomor_pendaftaran']];
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
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new AlternatifImport, $request->file('file_excel'));
        return redirect()->back()->with('success', 'Data siswa berhasil diimport!');
    }
}