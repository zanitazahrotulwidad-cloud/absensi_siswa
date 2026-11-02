
@extends('layouts.app')

@section('title', 'Mata Pelajaran')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h3>Mata Pelajaran</h3>
            <p class="text-muted mb-0">
                {{ $siswa->nama }} | Kelas {{ $siswa->kelas }}
            </p>
        </div>

        <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    @forelse ($jadwals as $mapelId => $daftarJadwal)
        @php
            $mapel = $daftarJadwal->first();
            $daftarGuru = $daftarJadwal->pluck('guru_nama')->unique();
        @endphp

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $mapel->mapel_nama }}</h5>

                <p class="text-muted mb-2">
                    Kode: {{ $mapel->mapel_kode ?? '-' }}
                </p>

                <p class="mb-2">
                    <strong>Guru:</strong>
                    {{ $daftarGuru->implode(', ') }}
                </p>

                <p class="mb-2">
                    <strong>Jadwal:</strong>
                    @foreach ($daftarJadwal as $jadwal)
                        <span class="badge bg-primary">
                            {{ $jadwal->hari }} |
                            {{ $jadwal->jam() }}
                        </span>
                    @endforeach
                </p>

                <p class="mb-0">
                    <strong>Jumlah Pertemuan:</strong>
                    {{ $daftarJadwal->count() }}
                </p>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            Belum ada mata pelajaran untuk kelas ini.
        </div>
    @endforelse

</div>
@endsection
