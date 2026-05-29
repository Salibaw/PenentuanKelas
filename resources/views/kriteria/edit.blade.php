<form action="{{ route('kriteria.update', $kriteria->id) }}" method="POST">
    @csrf 
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Nama Kriteria</label>
        <input type="text" name="nama_kriteria" class="form-control" value="{{ $kriteria->nama_kriteria }}" required>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Bobot (%)</label>
            <input type="number" name="bobot" class="form-control" value="{{ $kriteria->bobot }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Jenis</label>
            <select name="jenis" class="form-select">
                <option value="benefit" {{ $kriteria->jenis == 'benefit' ? 'selected' : '' }}>Benefit</option>
                <option value="cost" {{ $kriteria->jenis == 'cost' ? 'selected' : '' }}>Cost</option>
            </select>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Tipe Input</label>
        <select name="tipe_input" class="form-select">
            <option value="angka" {{ $kriteria->tipe_input == 'angka' ? 'selected' : '' }}>Angka (Manual)</option>
            <option value="pilihan" {{ $kriteria->tipe_input == 'pilihan' ? 'selected' : '' }}>Pilihan (Y/N)</option>
        </select>
    </div>
    <div class="modal-footer p-0 pt-3 border-top-0">
        <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-info ms-auto shadow-sm">Update Kriteria</button>
    </div>
</form>