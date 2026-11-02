
@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h3>Riwayat Absensi</h3>
            <p class="text-muted mb-0">
                {{ $siswa->nama }} | Kelas {{ $siswa->kelas }}
            </p>
        </div>

        <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    {{-- Rekap Absensi --}}
    <div class="row g-3 mb-4">
        @foreach ([
            'hadir' => ['Hadir', 'success'],
            'sakit' => ['Sakit', 'warning'],
            'izin' => ['Izin', 'info'],
            'alpa' => ['Alpa', 'danger'],
        ] as $status => [$label, $warna])
            <div class="col-md-3 col-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted mb-1">{{ $label }}</p>
                        <h3 class="mb-0">
                            {{ $rekap[$status] ?? 0 }}
                        </h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Filter Status --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('siswa.absensi.index') }}">
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label for="status" class="form-label">Filter Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Semua Status</option>

                            @foreach (\App\Models\Absensi::STATUS as $key => $label)
                                <option value="{{ $key }}"
                                    @selected(request('status') === $key)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">
                            Filter
                        </button>

                        <a href="{{ route('siswa.absensi.index') }}"
                           class="btn btn-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Riwayat --}}
    <div class="card shadow-sm">
        <div class="card-header">
            <strong>Riwayat Kehadiran</strong>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($absensis as $absensi)
                        <tr>
                            <td>
                                {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d-m-Y') }}
                            </td>
                            <td>{{ $absensi->mapel_nama }}</td>
                            <td>{{ $absensi->guru_nama }}</td>
                            <td>{{ ucfirst($absensi->status) }}</td>
                            <td>{{ $absensi->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada riwayat absensi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-body">
            {{ $absensis->links() }}
        </div>
    </div>

</div>
@endsection
