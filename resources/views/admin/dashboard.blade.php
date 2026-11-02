
@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-4">
    <h1 class="h3">Dashboard Admin</h1>
    <p class="text-muted">
        Selamat datang di aplikasi Absensi Siswa.
        {{ now()->translatedFormat('l, d F Y') }}
    </p>
</div>

{{-- Statistik --}}
<div class="row g-3 mb-4">
    @php
        $kartu = [
            ['label' => 'Total Guru', 'nilai' => $stats['guru'], 'warna' => 'primary'],
            ['label' => 'Total Siswa', 'nilai' => $stats['siswa'], 'warna' => 'success'],
            ['label' => 'Mata Pelajaran', 'nilai' => $stats['mapel'], 'warna' => 'warning'],
            ['label' => 'Total Jadwal', 'nilai' => $stats['jadwal'], 'warna' => 'info'],
            ['label' => 'Total Absensi', 'nilai' => $stats['absensi'], 'warna' => 'secondary'],
            ['label' => 'Hadir Hari Ini', 'nilai' => $stats['hadir_hari_ini'], 'warna' => 'success'],
        ];
    @endphp

    @foreach ($kartu as $item)
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card shadow-sm h-100 border-0 border-start border-4 border-{{ $item['warna'] }}">
                <div class="card-body">
                    <p class="text-muted small mb-2">{{ $item['label'] }}</p>
                    <h3 class="mb-0">{{ $item['nilai'] }}</h3>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- Jadwal dan absensi terbaru --}}
<div class="row g-3">
    <div class="col-lg-7">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">Jadwal Hari Ini</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Jam</th>
                                <th>Kelas</th>
                                <th>Mapel</th>
                                <th>Guru</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jadwalHariIni as $jadwal)
                                <tr>
                                    <td>
                                        {{ substr($jadwal->jam_mulai, 0, 5) }}
                                        -
                                        {{ substr($jadwal->jam_selesai, 0, 5) }}
                                    </td>
                                    <td>{{ $jadwal->kelas }}</td>
                                    <td>{{ $jadwal->mapel_nama }}</td>
                                    <td>{{ $jadwal->guru_nama }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">
                                        Tidak ada jadwal hari ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">Absensi Terbaru</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Mapel</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($absensiTerbaru as $absensi)
                                <tr>
                                    <td>{{ $absensi->siswa_nama }}</td>
                                    <td>{{ $absensi->mapel_nama }}</td>
                                    <td>{{ $absensi->tanggal->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge text-bg-{{ $absensi->badgeStatus() }}">
                                            {{ $absensi->statusLabel() }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">
                                        Belum ada data absensi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mt-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Kelola Data</h5>
    </div>
    <div class="card-body d-flex flex-wrap gap-2">
        <a href="{{ route('admin.guru.index') }}" class="btn btn-primary">
            Kelola Guru
        </a>

        <a href="{{ route('admin.siswa.index') }}" class="btn btn-success">
            Kelola Siswa
        </a>

        <a href="{{ route('admin.mapel.index') }}" class="btn btn-warning">
            Kelola Mata Pelajaran
        </a>

        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-info">
            Kelola Jadwal
        </a>
        
        <a href="{{ route('admin.absensi.index') }}" class="btn btn-secondary">
            Kelola Absensi
        </a>
    </div>
</div>
@endsection
