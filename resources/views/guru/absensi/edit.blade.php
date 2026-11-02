@extends('layouts.app')

@section('title', 'Edit Absensi')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Edit Absensi Siswa</h3>

        <a href="{{ route('guru.absensi.index') }}" class="btn btn-secondary">
            Kembali
        </a>
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
        <div class="card-header bg-warning">
            Form Edit Absensi
        </div>

        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Nama Siswa</label>
                <input type="text" class="form-control"
                    value="{{ $absensi->siswa_nama }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">NISN</label>
                <input type="text" class="form-control"
                    value="{{ $absensi->siswa_nisn }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" class="form-control"
                    value="{{ $absensi->jadwal_kelas }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Mata Pelajaran</label>
                <input type="text" class="form-control"
                    value="{{ $absensi->mapel_nama }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="text" class="form-control"
                    value="{{ $absensi->tanggal }}" disabled>
            </div>

            <form action="{{ route('guru.absensi.update', $absensi->id) }}"
                method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Status Kehadiran</label>

                    <select name="status" class="form-select" required>
                        @foreach (\App\Models\Absensi::STATUS as $key => $label)
                            <option value="{{ $key }}"
                                @selected(old('status', $absensi->status) === $key)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>

                    <textarea name="keterangan" class="form-control"
                        rows="3">{{ old('keterangan', $absensi->keterangan) }}</textarea>
                </div>

                <button type="submit" class="btn btn-warning">
                    Simpan Perubahan
                </button>

                <a href="{{ route('guru.absensi.index') }}"
                    class="btn btn-secondary">
                    Batal
                </a>
            </form>
        </div>
    </div>
</div>
@endsection