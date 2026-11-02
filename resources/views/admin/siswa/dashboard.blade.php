@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
    <div class="mb-4">
        <h1 class="h3">Dashboard Siswa</h1>
        <p class="text-muted">Selamat datang di aplikasi Absensi Siswa.</p>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Jadwal Pelajaran</h5>
                    <p class="card-text">Lihat jadwal pelajaran Anda.</p>
                    <span class="badge text-bg-info">Siswa</span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Riwayat Absensi</h5>
                    <p class="card-text">Lihat riwayat kehadiran Anda.</p>
                    <span class="badge text-bg-info">Siswa</span>
                </div>
            </div>
        </div>
    </div>
@endsection
