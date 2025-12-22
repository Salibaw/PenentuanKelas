<form action="{{ route('walikelas.update', $walikelas->id) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label class="form-label">NIP</label>
        <input type="text" name="nip" class="form-control" value="{{ $walikelas->nip }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama_guru" class="form-control" value="{{ $walikelas->nama_guru }}" required>
    </div>
    <div class="text-end">
        <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-info">Update Data</button>
    </div>
</form>