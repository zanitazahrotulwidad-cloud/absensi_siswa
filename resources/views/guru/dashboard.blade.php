@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="container py-4">

    <h3>Dashboard Guru</h3>
    <p>Selamat datang, {{ auth()->user()->name }}!</p>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5>Selamat Datang di Aplikasi Absensi Siswa</h5>
            <p class="mb-0">
                Silakan pilih menu untuk melihat informasi mengajar Anda.
            </p>
        </div>
    </div>

    {{-- Statistik Guru --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm h-100 border-primary">
                <div class="card-body">
                    <h6 class="text-muted">Mapel Diampu</h6>
                    <h2 class="text-primary mb-0">{{ $stats['mapel'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100 border-success">
                <div class="card-body">
                    <h6 class="text-muted">Jadwal Mengajar</h6>
                    <h2 class="text-success mb-0">{{ $stats['jadwal'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100 border-warning">
                <div class="card-body">
                    <h6 class="text-muted">Siswa Diajar</h6>
                    <h2 class="text-warning mb-0">{{ $stats['siswa'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100 border-info">
                <div class="card-body">
                    <h6 class="text-muted">Absensi Hari Ini</h6>
                    <h2 class="text-info mb-0">{{ $stats['absensi_hari_ini'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Menu Guru --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5>Jadwal Mengajar</h5>
                    <p>Lihat jadwal mengajar dan mata pelajaran Anda.</p>
                    <a href="{{ route('guru.jadwal.index') }}" class="btn btn-primary">
                        Lihat Jadwal
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5>Absensi Siswa</h5>
                    <p>Input dan lihat riwayat kehadiran siswa sesuai jadwal mengajar Anda.</p>
                    <a href="{{ route('guru.absensi.index') }}" class="btn btn-primary">
                        Kelola Absensi
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5>Mata Pelajaran Diampu</h5>
                    <p>Lihat daftar mata pelajaran dan jumlah kelas yang Anda ajar.</p>
                    <a href="{{ route('guru.mapel.index') }}" class="btn btn-primary">
                        Lihat Mata Pelajaran
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5>Siswa yang Diajar</h5>
                    <p>Lihat daftar siswa berdasarkan kelas yang Anda ajar.</p>
                    <a href="{{ route('guru.siswa.index') }}" class="btn btn-primary">
                        Lihat Siswa
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- Jadwal Mengajar Hari Ini --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white text-dark">
            <h6 class="mb-0 fw-semibold">
                Jadwal Mengajar Hari Ini: {{ $hariIni }}
            </h6>
        </div>

        <div class="card-body">
            @if ($jadwalHariIni->isEmpty())
                <div class="alert alert-info mb-0">
                    Tidak ada jadwal mengajar untuk hari ini.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>No.</th>
                                <th>Jam</th>
                                <th>Mata Pelajaran</th>
                                <th>Kelas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwalHariIni as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->jam() }}</td>
                                    <td>{{ $item->mapel_nama }}</td>
                                    <td>{{ $item->kelas }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection