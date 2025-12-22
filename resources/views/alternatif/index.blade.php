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
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><polyline points="7 11 12 16 17 11" /><line x1="12" y1="4" x2="12" y2="16" /></svg>
                        Unduh Template
                    </a>
                    <button type="button" class="btn btn-info shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-import-siswa">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><polyline points="7 9 12 4 17 9" /><line x1="12" y1="4" x2="12" y2="16" /></svg>
                        Import Siswa
                    </button>
                    <button type="button" id="btnTambahSiswa" class="btn btn-primary shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
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
                <div class="d-flex"><div>{{ session('success') }}</div></div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

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
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-muted">{{ $s->nomor_pendaftaran ?? '-' }}</td>
                            <td class="fw-bold text-dark">{{ $s->nama_lengkap }}</td>
                            <td>
                                <div class="btn-list flex-nowrap justify-content-center">
                                    <button class="btn btn-outline-info btn-icon edit" id="{{ $s->id }}" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
                                    </button>
                                    <form action="{{ route('alternatif.delete', $s->id) }}" method="POST" onsubmit="return confirm('Hapus siswa ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-icon" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Belum ada data siswa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Import --}}
<div class="modal modal-blur fade" id="modal-import-siswa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content shadow">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Import Data Siswa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('alternatif.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p class="text-muted">Gunakan template yang disediakan agar kolom sesuai.</p>
                    <input type="file" name="file" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">Mulai Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Tambah Manual --}}
<div class="modal modal-blur fade" id="modal-inputsiswa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Siswa Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('alternatif.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">No. Pendaftaran (Opsional)</label>
                        <input type="text" name="nomor_pendaftaran" class="form-control" placeholder="Contoh: PPDB-001">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap Siswa</label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama sesuai ijazah" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal modal-blur fade" id="modal-editsiswa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-azure text-white">
                <h5 class="modal-title">Perbarui Data Siswa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="load-edit-form">
                {{-- Form AJAX --}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(document).ready(function() {
        // Memperbaiki trigger modal tambah manual
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