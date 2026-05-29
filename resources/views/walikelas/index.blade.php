@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title text-primary">Data Wali Kelas</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        {{-- Alert Sukses --}}
        @if(session('success'))
            <div class="alert alert-important alert-success alert-dismissible shadow-sm border-0 mb-3" role="alert">
                <div class="d-flex">
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Alert Gagal / Eror Validasi Duplikat Data --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible shadow-sm border-0 mb-3" role="alert">
                <div class="d-flex">
                    <div>
                        <strong class="d-block mb-1">Penyimpanan Gagal:</strong>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <button class="btn btn-primary shadow-sm" id="btnTambahWali">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    Tambah Wali Kelas
                </button>

                {{-- Form Filter Pencarian --}}
                <form action="{{ route('walikelas.index') }}" method="GET" class="d-flex ms-auto align-items-center gap-2 m-0">
                    <div class="input-icon">
                        <input type="text" name="search" value="{{ $search ?? request('search') }}" class="form-control form-control-sm" placeholder="Cari Nama, NIP, atau Kelas...">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary shadow-sm">Cari</button>
                    @if(!empty($search) || request('search'))
                        <a href="{{ route('walikelas.index') }}" class="btn btn-sm btn-outline-danger">Reset</a>
                    @endif
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped">
                    <thead>
                        <tr>
                            <th class="w-1">No</th>
                            <th>NIP</th>
                            <th>Nama Lengkap</th>
                            <th>Kelas Penempatan</th>
                            <th class="w-1 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($walikelas as $w)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-muted">{{ $w->nip }}</td>
                            <td class="fw-bold text-dark">{{ $w->nama_guru }}</td>
                            <td>
                                <span class="badge bg-purple-lt px-2 py-1">Kelas {{ $w->kelas }}</span>
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap justify-content-center">
                                    <button class="btn btn-info btn-sm edit" id="{{ $w->id }}">Edit</button>
                                    <form action="{{ route('walikelas.delete', $w->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                @if(request('search'))
                                    Wali kelas dengan kata kunci "{{ request('search') }}" tidak ditemukan.
                                @else
                                    Belum ada data wali kelas.
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

{{-- Modal Tambah --}}
<div class="modal modal-blur fade" id="modal-inputwali" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Input Data Wali Kelas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('walikelas.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">NIP</label>
                        <input type="text" name="nip" class="form-control" placeholder="Contoh: 1980..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_guru" class="form-control" placeholder="Nama Beserta Gelar" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas Binaan</label>
                        {{-- PERBAIKAN: Mengubah input text menjadi Dropdown Dinamis --}}
                        <select name="kelas" class="form-select" required>
                            <option value="">- Pilih Kelas -</option>
                            {{-- Jika total data ada 4, looping akan berjalan 5 kali untuk memunculkan pilihan 7-1 sampai 7-5 --}}
                            @for($i = 1; $i <= ($walikelas->count() + 1); $i++)
                                <option value="7-{{ $i }}">Kelas 7-{{ $i }}</option>
                            @endfor
                        </select>
                        <small class="text-muted">Pilihan kelas digenerate otomatis berdasarkan jumlah wali kelas yang aktif.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary ms-auto">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal modal-blur fade" id="modal-editwali" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Edit Data Wali Kelas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="load-edit-form"></div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(document).ready(function() {
        $("#btnTambahWali").click(function(e) {
            e.preventDefault();
            $("#modal-inputwali").modal("show");
        });

        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            $("#load-edit-form").html('<div class="text-center py-5"><div class="spinner-border text-azure mb-2"></div><div>Memuat data...</div></div>');
            $("#modal-editwali").modal("show");

            $.ajax({
                type: 'POST',
                url: '{{ route("walikelas.edit") }}',
                data: { _token: "{{ csrf_token() }}", id: id },
                success: function(respond) {
                    $("#load-edit-form").html(respond);
                },
                error: function() {
                    $("#load-edit-form").html('<div class="alert alert-danger m-2">Gagal mengambil data form.</div>');
                }
            });
        });
    });
</script>
@endpush