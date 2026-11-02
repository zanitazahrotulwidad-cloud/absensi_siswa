
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h2>Tambah Guru</h2>
        <p class="text-muted">Masukkan data profil dan akun login guru.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.guru.store') }}" method="POST">
                @csrf

                <h5 class="mb-3">Data Akun Login</h5>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Login</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" maxlength="255" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required>
                    <div class="form-text">Minimal 8 karakter.</div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>
                <h5 class="mb-3">Data Profil Guru</h5>

                <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" name="nip" id="nip"
                        class="form-control @error('nip') is-invalid @enderror"
                        value="{{ old('nip') }}" maxlength="20" required>
                    @error('nip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Guru</label>
                    <input type="text" name="nama" id="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin"
                        class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                        value="{{ old('tanggal_lahir') }}">
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3"
                        class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
