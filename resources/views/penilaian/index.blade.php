@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title text-primary">Input Nilai Alternatif</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        {{-- Alert Success/Error --}}
        @if(session('success'))
            <div class="alert alert-success shadow-sm border-0">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger shadow-sm border-0">{{ session('error') }}</div>
        @endif

        <form action="{{ route('penilaian.store') }}" method="POST">
            @csrf
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="btn-list">
                        {{-- Tombol Simpan Manual --}}
                        <button type="submit" class="btn btn-success shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><circle cx="12" cy="14" r="2" /><polyline points="14 4 14 8 8 8 8 4" /></svg>
                            Simpan Semua Nilai
                        </button>

                        {{-- Tombol Export --}}
                        <a href="{{ route('penilaian.export') }}" class="btn btn-primary shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><polyline points="7 11 12 16 17 11" /><line x1="12" y1="4" x2="12" y2="16" /></svg>
                            Export Template
                        </a>

                        {{-- Tombol Import --}}
                        <button type="button" class="btn btn-info shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-import">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><polyline points="7 9 12 4 17 9" /><line x1="12" y1="4" x2="12" y2="16" /></svg>
                            Import Excel
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-bordered table-hover">
                        <thead>
                            <tr class="bg-light">
                                <th rowspan="2" class="text-center">Nama Siswa</th>
                                <th colspan="{{ $kriteria->count() }}" class="text-center">Kriteria Penilaian SMART</th>
                            </tr>
                            <tr class="bg-light">
                                @foreach($kriteria as $k)
                                <th class="text-center">{{ $k->nama_kriteria }} ({{ $k->bobot }}%)</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswa as $s)
                            <tr>
                                <td class="fw-bold text-dark">{{ $s->nama_lengkap }}</td>
                                @foreach($kriteria as $k)
                                @php
                                    $currentValue = '';
                                    if(isset($penilaian[$s->id])) {
                                        $rowNilai = $penilaian[$s->id]->where('kriteria_id', $k->id)->first();
                                        $currentValue = $rowNilai ? $rowNilai->nilai : '';
                                    }
                                @endphp
                                <td>
                                    @if($k->tipe_input == 'angka')
                                        <input type="number" step="0.01" name="nilai[{{ $s->id }}][{{ $k->id }}]"
                                            class="form-control form-control-sm" value="{{ $currentValue }}" placeholder="0">
                                    @else
                                        <select name="nilai[{{ $s->id }}][{{ $k->id }}]" class="form-select form-select-sm">
                                            <option value="">- Pilih -</option>
                                            <option value="100" {{ $currentValue == 100 && $currentValue !== '' ? 'selected' : '' }}>Ya (100)</option>
                                            <option value="0" {{ $currentValue == 0 && $currentValue !== '' ? 'selected' : '' }}>Tidak (0)</option>
                                        </select>
                                    @endif
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modal Import Excel --}}
<div class="modal modal-blur fade" id="modal-import" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Import Nilai Siswa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('penilaian.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih File Excel (.xlsx)</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx" required>
                        <small class="text-muted mt-2 d-block">Gunakan file yang diunduh dari tombol <strong>Export Template</strong> agar format sesuai.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info ms-auto shadow-sm">Proses Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection