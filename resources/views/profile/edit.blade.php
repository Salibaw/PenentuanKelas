@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <h2 class="page-title text-primary">Pengaturan Profil</h2>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('profile.update') }}" method="POST" class="card border-0 shadow-sm">
                    @csrf
                    @method('PUT')
                    <div class="card-header bg-white">
                        <h3 class="card-title">Informasi Pribadi</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">Password Baru (Kosongkan jika tidak ingin ganti)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                    <div class="card-footer bg-white text-end">
                        <button type="submit" class="btn btn-primary shadow-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm bg-blue-lt">
                    <div class="card-body text-center py-5">
                        <span class="avatar avatar-xl mb-3 rounded-circle" style="background-image: url(https://via.placeholder.com/150)"></span>
                        <h3 class="mb-1">{{ $user->name }}</h3>
                        <div class="text-muted">{{ $user->email }}</div>
                        <div class="mt-3">
                            <span class="badge bg-blue">Administrator</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection