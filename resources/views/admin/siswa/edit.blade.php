@extends('layouts.app')

@section('title', 'Ubah Siswa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Ubah Data Siswa</h1>
    <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">
        Kembali
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.siswa.update', $siswa->id) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nisn" class="form-label">NISN</label>
                    <input
                        type="text"
                        id="nisn"
                        name="nisn"
                        class="form-control @error('nisn') is-invalid @enderror"
                        value="{{ old('nisn', $siswa->nisn) }}"
                        maxlength="10"
                        inputmode="numeric"
                        required
                    >
                    @error('nisn')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama', $siswa->nama) }}"
                        required
                    >
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="kelas" class="form-label">Kelas</label>
                    <input
                        type="text"
                        id="kelas"
                        name="kelas"
                        class="form-control @error('kelas') is-invalid @enderror"
                        value="{{ old('kelas', $siswa->kelas) }}"
                        required
                    >
                    @error('kelas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select
                        id="jenis_kelamin"
                        name="jenis_kelamin"
                        class="form-select @error('jenis_kelamin') is-invalid @enderror"
                        required
                    >
                        <option value="">-- Pilih --</option>
                        <option value="L" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) === 'L')>
                            Laki-laki
                        </option>
                        <option value="P" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) === 'P')>
                            Perempuan
                        </option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input
                        type="date"
                        id="tanggal_lahir"
                        name="tanggal_lahir"
                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                        value="{{ old('tanggal_lahir', $siswa->tanggal_lahir?->format('Y-m-d')) }}"
                    >
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea
                        id="alamat"
                        name="alamat"
                        class="form-control @error('alamat') is-invalid @enderror"
                        rows="2"
                    >{{ old('alamat', $siswa->alamat) }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <hr>
                    <h2 class="h5">Akun Login Siswa</h2>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $email) }}"
                        required
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label">Kata Sandi Baru</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        minlength="6"
                        autocomplete="new-password"
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Kosongkan jika tidak ingin mengganti kata sandi.</div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
