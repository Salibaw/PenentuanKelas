<form action="{{ route('alternatif.update', $siswa->id) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label class="form-label">No. Pendaftaran</label>
        <input type="text" name="nomor_pendaftaran" class="form-control" value="{{ $siswa->nomor_pendaftaran }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama_siswa" class="form-control" value="{{ $siswa->nama_siswa }}" required>
    </div>
    <div class="modal-footer p-0 pt-3">
        <button type="submit" class="btn btn-info w-100">Update Data</button>
    </div>
</form>