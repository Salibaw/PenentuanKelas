@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title text-primary">Data Siswa (Alternatif)</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <button class="btn btn-primary shadow-sm" id="btnTambahSiswa">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    Tambah Siswa
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped">
                    <thead>
                        <tr>
                            <th class="w-1">No</th>
                            <th>No. Pendaftaran</th>
                            <th>Nama Lengkap</th>
                            <th class="w-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $s)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-muted">{{ $s->nomor_pendaftaran ?? '-' }}</td>
                            <td class="fw-bold text-dark">{{ $s->nama_lengkap }}</td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <button class="btn btn-info btn-sm edit" id="{{ $s->id }}">Edit</button>
                                    <form action="{{ route('alternatif.delete', $s->id) }}" method="POST" onsubmit="return confirm('Hapus siswa ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Belum ada data siswa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal modal-blur fade" id="modal-inputsiswa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Siswa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('alternatif.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">No. Pendaftaran (Opsional)</label>
                        <input type="text" name="nomor_pendaftaran" class="form-control" placeholder="Contoh: PPDB-001">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap Siswa</label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary ms-auto">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal modal-blur fade" id="modal-editsiswa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Edit Data Siswa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="load-edit-form"></div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(document).ready(function() {
        $("#btnTambahSiswa").click(function() {
            $("#modal-inputsiswa").modal("show");
        });

        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            $("#modal-editsiswa").modal("show");
            $("#load-edit-form").html('<div class="text-center py-4"><div class="spinner-border text-primary"></div></div>');
            $.ajax({
                type: 'POST',
                url: '{{ route("alternatif.edit") }}',
                data: { _token: "{{ csrf_token() }}", id: id },
                success: function(respond) {
                    $("#load-edit-form").html(respond);
                }
            });
        });
    });
</script>
@endpush