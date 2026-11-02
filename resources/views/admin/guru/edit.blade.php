
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Edit Data Guru</h5>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h5 class="mb-3">Data Akun Login</h5>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Login</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $guru->user_email ?? '') }}"
                                maxlength="255" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Kata Sandi Baru</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror">
                            <div class="form-text">
                                Kosongkan jika tidak ingin mengubah kata sandi.
                            </div>
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
                                value="{{ old('nip', $guru->nip) }}"
                                maxlength="20" required>
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Guru</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $guru->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin"
                                class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                value="{{ old('tanggal_lahir', $guru->tanggal_lahir?->format('Y-m-d')) }}">
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="3"
                                class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $guru->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
