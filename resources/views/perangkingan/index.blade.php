@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title text-primary">Hasil Perangkingan & Pembagian Kelas</h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                            Cetak Daftar Kelas
                        </button>
                        <div class="dropdown-menu">
                            {{-- Modifikasi agar list cetak tetap muncul walaupun sedang memfilter pencarian nama --}}
                            @foreach(\App\Models\HasilSpk::pluck('kelas')->unique() as $kls)
                            <a class="dropdown-item" href="{{ route('perangkingan.cetak', ['kelas' => $kls]) }}" target="_blank">
                                Kelas {{ $kls }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <form action="{{ route('perangkingan.hitung') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary shadow-sm">Mulai Perhitungan SMART</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 mb-3">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger shadow-sm border-0 mb-3">{{ session('error') }}</div>
        @endif

        <div class="card border-0 shadow-sm">
            
            {{-- Tambahan Komponen Card Header untuk Form Pencarian Nama --}}
            <div class="card-header bg-white py-3">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <h3 class="card-title text-muted m-0">Daftar Peringkat Siswa</h3>
                    
                    {{-- Form Filter Pencarian --}}
                    <form action="{{ route('perangkingan.index') }}" method="GET" class="d-flex align-items-center gap-2 m-0">
                        <div class="input-icon">
                            <input type="text" name="search_nama" value="{{ $searchNama ?? request('search_nama') }}" class="form-control form-control-sm" placeholder="Cari nama siswa...">
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary shadow-sm">Cari</button>
                        
                        @if(!empty($searchNama) || request('search_nama'))
                            <a href="{{ route('perangkingan.index') }}" class="btn btn-sm btn-outline-danger">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped m-0">
                    <thead>
                        <tr>
                            <th class="w-1 text-center">Rank</th>
                            <th>Nama Siswa</th>
                            <th>Total Skor</th>
                            <th>Penempatan Kelas</th>
                            <th>Wali Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasil as $h)
                        <tr>
                            <td class="text-center">
                                <span class="badge bg-{{ $h->ranking <= 5 ? 'yellow' : 'blue' }}-lt p-2">
                                    {{ $h->ranking }}
                                </span>
                            </td>
                            <td class="fw-bold text-dark">{{ $h->alternatif->nama_lengkap }}</td>
                            <td class="text-monospace text-secondary">{{ number_format($h->total_skor, 4) }}</td>
                            <td>
                                <span class="badge bg-purple-lt px-2 py-1">Kelas {{ $h->kelas }}</span>
                            </td>
                            <td>
                                <div class="small text-muted">NIP: {{ $h->walikelas->nip ?? '-' }}</div>
                                <div class="fw-bold text-dark">{{ $h->walikelas->nama_guru ?? 'Belum Ditentukan' }}</div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                @if(request('search_nama'))
                                    Siswa dengan nama "{{ request('search_nama') }}" tidak ditemukan dalam hasil perangkingan.
                                @else
                                    Belum ada data hasil. Silakan klik tombol <strong>Mulai Perhitungan SMART</strong>.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection