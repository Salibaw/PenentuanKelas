@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title text-primary">Data Kriteria SMART</h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="badge bg-{{ $totalBobot == 100 ? 'success' : 'danger' }}-lt p-2">
                    Total Bobot: {{ $totalBobot }}%
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <button class="btn btn-primary shadow-sm" id="btnTambahKriteria">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Tambah Kriteria
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Nama Kriteria</th>
                            <th>Bobot</th>
                            <th>Tipe Input</th>
                            <th>Jenis</th>
                            <th class="w-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kriteria as $k)
                        <tr>
                            <td class="fw-bold">{{ $k->nama_kriteria }}</td>
                            <td><span class="badge bg-blue-lt">{{ $k->bobot }}%</span></td>
                            <td>
                                <span class="badge bg-{{ $k->tipe_input == 'angka' ? 'purple' : 'orange' }}-lt">
                                    {{ ucfirst($k->tipe_input) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $k->jenis == 'benefit' ? 'green' : 'red' }}-lt">
                                    {{ ucfirst($k->jenis) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <button class="btn btn-info btn-sm edit" id="{{ $k->id }}">Edit</button>
                                    <form action="{{ route('kriteria.delete', $k->id) }}" method="POST" onsubmit="return confirm('Hapus kriteria ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-inputkriteria" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Kriteria Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('kriteria.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kriteria</label>
                        <input type="text" name="nama_kriteria" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bobot (%)</label>
                            <input type="number" name="bobot" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis</label>
                            <select name="jenis" class="form-select">
                                <option value="benefit">Benefit</option>
                                <option value="cost">Cost</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Input</label>
                        <select name="tipe_input" class="form-select">
                            <option value="angka">Angka (Manual)</option>
                            <option value="pilihan">Pilihan (Y/N)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary ms-auto">Simpan Kriteria</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal untuk menampung isi dari file edit.blade.php --}}
<div class="modal modal-blur fade" id="modal-editkriteria" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Edit Data Kriteria</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="load-edit-form">
                {{-- Form dari file edit.blade.php akan muncul di sini --}}
            </div>
        </div>
    </div>
</div>

@endsection

@push('myscript')
<script>
    $(document).ready(function() {
        $("#btnTambahKriteria").click(function() {
            $("#modal-inputkriteria").modal("show");
        });

        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            $("#modal-editkriteria").modal("show");
            $("#load-edit-form").html('<div class="spinner-border text-primary"></div>');
            $.ajax({
                type: 'POST',
                url: '{{ route("kriteria.edit") }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(respond) {
                    $("#load-edit-form").html(respond);
                }
            });
        });
    });
</script>
@endpush