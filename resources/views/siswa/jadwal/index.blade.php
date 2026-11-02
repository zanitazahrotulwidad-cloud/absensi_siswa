
@extends('layouts.app')

@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h3>Jadwal Pelajaran</h3>
            <p class="text-muted mb-0">
                {{ $siswa->nama }} | Kelas {{ $siswa->kelas }}
            </p>
        </div>

        <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    @forelse ($jadwals as $hari => $daftarJadwal)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <strong>{{ $hari }}</strong>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Jam</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($daftarJadwal as $jadwal)
                                <tr>
                                    <td>{{ $jadwal->jam() }}</td>
                                    <td>{{ $jadwal->mapel_nama }}</td>
                                    <td>{{ $jadwal->guru_nama }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            Belum ada jadwal pelajaran untuk kelas ini.
        </div>
    @endforelse

</div>
@endsection
