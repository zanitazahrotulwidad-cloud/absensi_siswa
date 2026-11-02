
@extends('layouts.app')

@section('title', 'Jadwal Mengajar')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3>Jadwal Mengajar</h3>
            <p class="text-muted mb-0">Daftar jadwal mengajar Anda.</p>
        </div>
        <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary">
            Kembali ke Dashboard
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($jadwal->isEmpty())
        <div class="alert alert-info">
            Belum ada jadwal mengajar yang tersedia.
        </div>
    @else
        @foreach ($jadwal->groupBy('hari') as $hari => $daftarJadwal)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <span class="badge bg-{{ $daftarJadwal->first()->badgeHari() }}">
                            {{ $hari }}
                        </span>
                    </h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Jam</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($daftarJadwal as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->jam() }}</td>
                                        <td>{{ $item->mapel_nama }}</td>
                                        <td>{{ $item->kelas }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
