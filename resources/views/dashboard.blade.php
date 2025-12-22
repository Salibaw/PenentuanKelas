@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <h2 class="page-title text-primary">Dashboard SPK SMART</h2>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm border-0 shadow-sm bg-blue-lt">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-blue text-white avatar shadow">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                    </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">{{ $data['total_siswa'] }} Siswa</div>
                                <div class="text-muted small">Total Terdaftar</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm border-0 shadow-sm bg-green-lt">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-green text-white avatar shadow">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 12h4l3 8l4 -16l3 8h4" />
                                    </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">{{ $data['total_kriteria'] }} Kriteria</div>
                                <div class="text-muted small">Bobot SMART Terpasang</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm border-0 shadow-sm bg-purple-lt">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-purple text-white avatar shadow">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <circle cx="12" cy="7" r="4" />
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">{{ $data['total_guru'] }} Wali Kelas</div>
                                <div class="text-muted small">Tersedia</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm border-0 shadow-sm {{ $data['sudah_hitung'] > 0 ? 'bg-orange-lt' : 'bg-secondary-lt' }}">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-orange text-white avatar shadow">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 10l5 -6l5 6" />
                                        <path d="M21 10l-2 8a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2l-2 -8" />
                                        <path d="M12 10l0 10" />
                                    </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">{{ $data['sudah_hitung'] }} Hasil</div>
                                <div class="text-muted small">Siswa Teranking</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h3 class="card-title">Ranking 5 Teratas</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Nama</th>
                                    <th>Skor SMART</th>
                                    <th>Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['top_5'] as $top)
                                <tr>
                                    <td><span class="badge bg-yellow-lt p-2">#{{ $top->ranking }}</span></td>
                                    <td class="fw-bold">{{ $top->alternatif->nama_lengkap }}</td>
                                    <td>{{ number_format($top->total_skor, 4) }}</td>
                                    <td><span class="badge bg-blue-lt">{{ $top->kelas }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h3 class="card-title">Distribusi Siswa</h3>
                    </div>
                    <div class="card-body">
                        @foreach($data['distribusi_kelas'] as $dist)
                        <div class="mb-3">
                            <div class="d-flex mb-1 small fw-bold">
                                <div>Kelas {{ $dist->kelas }}</div>
                                <div class="ms-auto">{{ $dist->total }} Siswa</div>
                            </div>
                            <div class="progress progress-sm shadow-sm">
                                <div class="progress-bar bg-primary" style="--width-persen: {{ $dist->persen }}%; width: var(--width-persen);"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection