@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h1 class="h3 mb-0">Jadwal Pelajaran</h1>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                Kembali ke Dashboard
            </a>
            <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary">
                Tambah Jadwal
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form action="{{ route('admin.jadwal.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label for="hari" class="form-label">Filter Hari</label>
                        <select name="hari" id="hari" class="form-select">
                            <option value="">Semua Hari</option>
                            @foreach (\App\Models\Jadwal::HARI as $hari)
                                <option value="{{ $hari }}" @selected(request('hari') === $hari)>
                                    {{ $hari }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label for="kelas" class="form-label">Filter Kelas</label>
                        <select name="kelas" id="kelas" class="form-select">
                            <option value="">Semua Kelas</option>
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas }}" @selected(request('kelas') === $kelas)>
                                    {{ $kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Guru</th>
                            <th width="160">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jadwals as $jadwal)
                            <tr>
                                <td>{{ $jadwals->firstItem() + $loop->index }}</td>
                                <td>
                                    <span class="badge text-bg-{{ $jadwal->badgeHari() }}">
                                        {{ $jadwal->hari }}
                                    </span>
                                </td>
                                <td>{{ $jadwal->jam() }}</td>
                                <td>{{ $jadwal->kelas }}</td>
                                <td>{{ $jadwal->mapel_nama }}</td>
                                <td>{{ $jadwal->guru_nama }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.jadwal.edit', $jadwal) }}"
                                           class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.jadwal.destroy', $jadwal) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
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
                                <td colspan="7" class="text-center text-muted py-4">
                                    Belum ada data jadwal pelajaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $jadwals->links() }}
        </div>
    </div>
</div>
@endsection