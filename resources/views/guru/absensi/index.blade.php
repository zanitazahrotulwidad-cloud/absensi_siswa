@extends('layouts.app')

@section('title', 'Data Absensi Siswa')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Data Absensi Siswa</h3>

        <div>
            <a href="{{ route('guru.absensi.create') }}" class="btn btn-success">
                + Input Absensi
            </a>

            <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Filter Absensi --}}
            <form action="{{ route('guru.absensi.index') }}" method="GET" class="row g-3 mb-4">

                <div class="col-md-4">
                    <label class="form-label">Jadwal Mengajar</label>
                    <select name="jadwal_id" class="form-select">
                        <option value="">Semua Jadwal</option>

                        @foreach ($jadwals as $jadwal)
                            <option value="{{ $jadwal->id }}"
                                {{ request('jadwal_id') == $jadwal->id ? 'selected' : '' }}>
                                {{ $jadwal->hari }} - {{ $jadwal->mapel_nama }}
                                ({{ $jadwal->kelas }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Tanggal Absensi</label>
                    <input type="date"
                        name="tanggal"
                        class="form-control"
                        value="{{ request('tanggal') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="alpa" {{ request('status') == 'alpa' ? 'selected' : '' }}>Alpa</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        Filter
                    </button>

                    <a href="{{ route('guru.absensi.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>

            </form>

            {{-- Tabel Absensi --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Nama Siswa</th>
                            <th>NISN</th>
                            <th>Kelas</th>
                            <th>Mapel</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($absensi as $item)
                            <tr>
                                <td>{{ $absensi->firstItem() + $loop->index }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->siswa_nama }}</td>
                                <td>{{ $item->siswa_nisn }}</td>
                                <td>{{ $item->jadwal_kelas }}</td>
                                <td>{{ $item->mapel_nama }}</td>
                                <td>{{ $item->statusLabel() }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('guru.absensi.edit', $item->id) }}"
                                            class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <form action="{{ route('guru.absensi.destroy', $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data absensi ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    Belum ada data absensi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $absensi->links() }}

        </div>
    </div>
</div>
@endsection