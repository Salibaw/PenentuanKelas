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
                            @foreach($hasil->pluck('kelas')->unique() as $kls)
                            <a class="dropdown-item" href="{{ route('perangkingan.cetak', ['kelas' => $kls]) }}" target="_blank">
                                Kelas {{ $kls }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <form action="{{ route('perangkingan.hitung') }}" method="POST">
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
        <div class="alert alert-success shadow-sm border-0">{{ session('success') }}</div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped">
                    <thead>
                        <tr>
                            <th class="w-1">Rank</th>
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
                            <td class="fw-bold">{{ $h->alternatif->nama_lengkap }}</td>
                            <td>{{ number_format($h->total_skor, 4) }}</td>
                            <td>
                                <span class="badge bg-purple-lt">{{ $h->kelas }}</span>
                            </td>
                            <td>
                                <div class="small text-muted">NIP: {{ $h->walikelas->nip ?? '-' }}</div>
                                <div class="fw-bold">{{ $h->walikelas->nama_guru ?? 'Belum Ditentukan' }}</div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                Belum ada data hasil. Silakan klik tombol <strong>Mulai Perhitungan SMART</strong>.
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