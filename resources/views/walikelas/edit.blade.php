<form action="{{ route('walikelas.update', $walikelas->id) }}" method="POST">
    @csrf 
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">NIP</label>
        <input type="text" name="nip" class="form-control" value="{{ $walikelas->nip }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama_guru" class="form-control" value="{{ $walikelas->nama_guru }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Kelas Binaan</label>
        {{-- PERBAIKAN: Dropdown untuk form edit --}}
        <select name="kelas" class="form-select" required>
            <option value="">- Pilih Kelas -</option>
            
            {{-- Mengambil total seluruh wali kelas dari database untuk batas looping opsi --}}
            @php
                $totalWali = \App\Models\WaliKelas::count();
                // Pastikan batas looping minimal menampung jumlah data saat ini agar opsi tidak hilang
                $maxLoop = $totalWali > 0 ? $totalWali : 1;
            @endphp

            @for($i = 1; $i <= $maxLoop; $i++)
                @php $namaKls = '7-' . $i; @endphp
                <option value="{{ $namaKls }}" {{ $walikelas->kelas == $namaKls ? 'selected' : '' }}>
                    Kelas {{ $namaKls }}
                </option>
            @endfor
        </select>
    </div>
    <div class="modal-footer p-0 pt-3">
        <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-info ms-auto shadow-sm">Update Data</button>
    </div>
</form>