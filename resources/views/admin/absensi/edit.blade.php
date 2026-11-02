
@extends('layouts.app')

@section('title', 'Edit Absensi')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Edit Absensi</h3>
            <p class="text-muted mb-0">Perbarui status kehadiran siswa.</p>
        </div>
        <a href="{{ route('admin.absensi.index') }}" class="btn btn-outline-secondary">
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

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Nama Siswa</label>
                    <div class="fw-semibold">{{ $absensi->siswa_nama }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">NISN</label>
                    <div class="fw-semibold">{{ $absensi->siswa_nisn }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Kelas</label>
                    <div class="fw-semibold">{{ $absensi->jadwal_kelas }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Mata Pelajaran</label>
                    <div class="fw-semibold">{{ $absensi->mapel_nama }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Tanggal</label>
                    <div class="fw-semibold">{{ $absensi->tanggal->format('d/m/Y') }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Jam Pelajaran</label>
                    <div class="fw-semibold">
                        {{ substr($absensi->jadwal_jam_mulai, 0, 5) }}
                        -
                        {{ substr($absensi->jadwal_jam_selesai, 0, 5) }}
                    </div>
                </div>
            </div>

            <hr>

            <form method="POST" action="{{ route('admin.absensi.update', $absensi->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="status" class="form-label">Status Kehadiran</label>
                    <select name="status" id="status" class="form-select" required>
                        @foreach (\App\Models\Absensi::STATUS as $key => $label)
                            <option value="{{ $key }}"
                                @selected(old('status', $absensi->status) === $key)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                        maxlength="255" class="form-control"
                        placeholder="Keterangan tambahan (opsional)">{{ old('keterangan', $absensi->keterangan) }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.absensi.index') }}"
                        class="btn btn-outline-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
