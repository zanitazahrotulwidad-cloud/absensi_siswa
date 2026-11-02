
@extends('layouts.app')

@section('title', 'Data Absensi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Data Absensi</h3>
        <p class="text-muted mb-0">Kelola dan pantau kehadiran siswa.</p>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ url('/admin/dashboard') }}" class="btn btn-outline-secondary">
            Kembali ke Dashboard
        </a>
        <a href="{{ route('admin.absensi.create') }}" class="btn btn-primary">
            + Input Absensi
        </a>
    </div>
</div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.absensi.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Jadwal Pelajaran</label>
                        <select name="jadwal_id" class="form-select">
                            <option value="">Semua Jadwal</option>
                            @foreach ($jadwalList as $jadwal)
                                <option value="{{ $jadwal->id }}"
                                    @selected(request('jadwal_id') == $jadwal->id)>
                                    {{ $jadwal->kelas }} - {{ $jadwal->mapel_nama }}
                                    ({{ $jadwal->hari }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control"
                            value="{{ request('tanggal') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            @foreach (\App\Models\Absensi::STATUS as $key => $label)
                                <option value="{{ $key }}"
                                    @selected(request('status') === $key)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            Filter
                        </button>
                        <a href="{{ route('admin.absensi.index') }}"
                            class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Jam</th>
                            <th>Siswa</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($absensis as $absensi)
                            <tr>
                                <td>{{ $absensi->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $absensi->jadwal_kelas }}</td>
                                <td>{{ $absensi->mapel_nama }}</td>
                                <td>
                                    {{ substr($absensi->jadwal_jam_mulai, 0, 5) }}
                                    -
                                    {{ substr($absensi->jadwal_jam_selesai, 0, 5) }}
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $absensi->siswa_nama }}</div>
                                    <small class="text-muted">{{ $absensi->siswa_nisn }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-{{
                                        match ($absensi->status) {
                                            'hadir' => 'success',
                                            'sakit' => 'warning',
                                            'izin' => 'info',
                                            'alpa' => 'danger',
                                            default => 'secondary'
                                        }
                                    }}">
                                        {{ $absensi->statusLabel() }}
                                    </span>
                                </td>
                                <td>{{ $absensi->keterangan ?: '-' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.absensi.edit', $absensi->id) }}"
                                            class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.absensi.destroy', $absensi->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data absensi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Belum ada data absensi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $absensis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
