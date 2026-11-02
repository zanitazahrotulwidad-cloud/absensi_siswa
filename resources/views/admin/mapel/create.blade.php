
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h2>Tambah Mata Pelajaran</h2>
        <p class="text-muted">Masukkan data mata pelajaran baru.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.mapel.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="kode" class="form-label">Kode Mata Pelajaran</label>
                    <input
                        type="text"
                        name="kode"
                        id="kode"
                        class="form-control @error('kode') is-invalid @enderror"
                        value="{{ old('kode') }}"
                        maxlength="20"
                        required
                    >
                    @error('kode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Mata Pelajaran</label>
                    <input
                        type="text"
                        name="nama"
                        id="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}"
                        required
                    >
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.mapel.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
