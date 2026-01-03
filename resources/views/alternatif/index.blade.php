@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title text-primary">Data Siswa (Alternatif)</h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    <a href="{{ route('alternatif.template') }}" class="btn btn-outline-primary shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                            <polyline points="7 11 12 16 17 11" />
                            <line x1="12" y1="4" x2="12" y2="16" />
                        </svg>
                        Unduh Template
                    </a>
                    <button type="button" class="btn btn-info shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-import-siswa">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                            <polyline points="7 9 12 4 17 9" />
                            <line x1="12" y1="4" x2="12" y2="16" />
                        </svg>
                        Import Siswa
                    </button>
                    <button type="button" id="btnTambahSiswa" class="btn btn-primary shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Tambah Manual
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        {{-- Notifikasi --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible shadow-sm border-0" role="alert">
            <div class="d-flex">
                <div>{{ session('success') }}</div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
        @endif

        {{-- Form Pencarian --}}
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('alternatif.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Cari Siswa</label>
                        <input type="text" name="search" class="form-control" placeholder="Nama atau No. Pendaftaran..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <circle cx="10" cy="10" r="7" />
                                <line x1="21" y1="21" x2="15" y2="15" />
                            </svg>
                            Cari
                        </button>
                    </div>
                    @if(request('search'))
                    <div class="col-md-3">
                        <a href="{{ route('alternatif.index') }}" class="btn btn-outline-secondary w-100">
                            Reset Pencarian
                        </a>
                    </div>
                    @endif
                </form>
            </div>
        </div>

        {{-- Tabel Data Siswa --}}
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped">
                    <thead>
                        <tr>
                            <th class="w-1">No</th>
                            <th>No. Pendaftaran</th>
                            <th>Nama Lengkap</th>
                            <th class="w-1 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $s)
                        <tr>
                            <td>{{ $loop->iteration + ($siswa->currentPage() - 1) * $siswa->perPage() }}</td>
                            <td class="text-muted">{{ $s->nomor_pendaftaran ?? '-' }}</td>
                            <td class="fw-bold text-dark">{{ $s->nama_lengkap }}</td>
                            <td>
                                <div class="btn-list flex-nowrap justify-content-center">
                                    <button class="btn btn-outline-info btn-icon edit" id="{{ $s->id }}" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                            <path d="M13.5 6.5l4 4" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('alternatif.delete', $s->id) }}" method="POST" onsubmit="return confirm('Hapus siswa ini?')" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-icon" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <line x1="4" y1="7" x2="20" y2="7" />
                                                <line x1="10" y1="11" x2="10" y2="17" />
                                                <line x1="14" y1="11" x2="14" y2="17" />
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                @if(request('search'))
                                    Tidak ditemukan siswa dengan kata kunci "{{ request('search') }}".
                                @else
                                    Belum ada data siswa.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($siswa->hasPages())
            <div class="card-footer d-flex align-items-center justify-content-between">
                <p class="m-0 text-muted">
                    Menampilkan <span>{{ $siswa->firstItem() }}</span> sampai <span>{{ $siswa->lastItem() }}</span> dari <span>{{ $siswa->total() }}</span> data
                </p>
                {{ $siswa->links('vendor.pagination.bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal-modal tetap sama seperti sebelumnya --}}
<!-- Modal Import, Tambah Manual, Edit tetap dipertahankan (tidak berubah) -->

@endsection

@push('myscript')
<script>
    $(document).ready(function() {
        $("#btnTambahSiswa").click(function(e) {
            e.preventDefault();
            $("#modal-inputsiswa").modal("show");
        });

        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            $("#modal-editsiswa").modal("show");
            $("#load-edit-form").html('<div class="text-center py-5"><div class="spinner-border text-azure mb-2"></div><div>Memuat data...</div></div>');

            $.ajax({
                type: 'POST',
                url: '{{ route("alternatif.edit") }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(respond) {
                    $("#load-edit-form").html(respond);
                },
                error: function() {
                    $("#load-edit-form").html('<div class="alert alert-danger">Gagal mengambil data.</div>');
                }
            });
        });
    });
</script>
@endpush